{
  config,
  lib,
  pkgs,
  ...
}: let
  cfg = config.services.twasgood;
in {
  options.services.twasgood = {
    enable = lib.mkEnableOption "twagood";

    package = lib.mkOption {
      type = lib.types.package;
      default = pkgs.callPackage (import ./default.nix) {};
    };

    createUser = lib.mkOption {
      type = lib.types.bool;
      default = true;
      description = "Create the user specified in <option>services.twasgood.user</option>";
    };

    createGroup = lib.mkOption {
      type = lib.types.bool;
      default = true;
      description = "Create the group specified in <option>services.twasgood.group</option>";
    };

    user = lib.mkOption {
      type = lib.types.str;
      default = "twasgood";
      description = "User twasgood runs as.";
    };

    group = lib.mkOption {
      type = lib.types.str;
      default = "twasgood";
      description = "Group twasgood runs as.";
    };

    host = lib.mkOption {
      type = lib.types.str;
      default = "127.0.0.1";
      description = "The address the server should bind to.";
    };

    port = lib.mkOption {
      type = lib.types.int;
      default = 80;
      description = "The port the server should bind to.";
    };

    workerCount = lib.mkOption {
      type = lib.types.int;
      default = -1;
      description = "The number of workers that should be available to handle requests. -1 defaults to the value Laravel Octane picks, usually the number of cores";
    };

    home = lib.mkOption {
      type = lib.types.str;
      default = "/var/lib/twasgood";
      description = "Storage path for twasgood";
    };

    phpPackage = lib.mkPackageOption pkgs "php83" {};

    envFile = lib.mkOption {
      type = lib.types.str;
      description = "A path to the dotenv file which configures Laravel";
    };
  };

  config = lib.mkIf cfg.enable (let
    phpPackage = cfg.phpPackage.buildEnv {
      extensions = exts: exts.enabled ++ (with exts.all; [swoole]);
    };
    bootstrapPath = cfg.home + "/bootstrap";
    storagePath = cfg.home + "/storage";
  in {
    environment.systemPackages = [
      (
        pkgs.writeShellScriptBin "twasgood" ''
          set -a
          . ${cfg.envFile}
          set +a
          LARAVEL_BOOTSTRAP_PATH=${bootstrapPath} LARAVEL_STORAGE_PATH=${storagePath} ${phpPackage}/bin/php ${cfg.package}/artisan $@
        ''
      )
    ];
    users = {
      users = lib.mkIf cfg.createUser {
        twasgood = {
          home = "${cfg.home}";
          group = "${cfg.group}";
          isSystemUser = true;
        };
      };

      groups = lib.mkIf cfg.createGroup {
        twasgood.members = ["${cfg.user}" "traefik"];
      };
    };

    systemd.services = {
      twasgood-setup = {
        wantedBy = ["multi-user.target"];
        before = ["twasgood.service"];
        script = ''
          rm -rf ${bootstrapPath}/cache
          mkdir -m 0700 ${bootstrapPath}/cache
          chown -R ${cfg.user}:${cfg.group} ${bootstrapPath}/cache

          ${phpPackage}/bin/php ${cfg.package}/artisan optimize:clear --env=${cfg.envFile}
          ${phpPackage}/bin/php ${cfg.package}/artisan optimize --env=${cfg.envFile}
          ${phpPackage}/bin/php ${cfg.package}/artisan scout:delete-all-index
          ${phpPackage}/bin/php ${cfg.package}/artisan scout:import "\App\Models\Recipe"
          ${phpPackage}/bin/php ${cfg.package}/artisan scout:index "\App\Models\Recipe"
        '';
        serviceConfig = {
          Type = "oneshot";
          User = "${cfg.user}";
          Environment = [
            "LARAVEL_BOOTSTRAP_PATH=${bootstrapPath}"
            "LARAVEL_STORAGE_PATH=${storagePath}"
          ];
          EnvironmentFile = [cfg.envFile];
        };
      };

      twasgood = {
        description = "Twasgood";
        wantedBy = ["multi-user.target"];
        serviceConfig = {
          ExecStart = lib.escapeShellArgs [
            "${phpPackage}/bin/php"
            "${cfg.package}/artisan"
            "octane:start"
            "--server=swoole"
            "--no-interaction"
            "--host"
            cfg.host
            "--port"
            cfg.port
            "--workers"
            (
              if cfg.workerCount == -1
              then "auto"
              else cfg.workerCount
            )
          ];
          Environment = [
            "LARAVEL_BOOTSTRAP_PATH=${bootstrapPath}"
            "LARAVEL_STORAGE_PATH=${storagePath}"
          ];
          EnvironmentFile = [cfg.envFile];
          User = "${cfg.user}";
          Restart = "always";
        };
      };
    };

    systemd.tmpfiles.rules =
      map (dir: "d ${dir} 0700 ${cfg.user} ${cfg.group} - -") [
        "${cfg.home}"
        "${cfg.home}/bootstrap"
        "${cfg.home}/bootstrap/cache"
        "${cfg.home}/storage"
        "${cfg.home}/storage/app"
        "${cfg.home}/storage/app/public"
        "${cfg.home}/storage/framework"
        "${cfg.home}/storage/framework/cache"
        "${cfg.home}/storage/framework/cache/data"
        "${cfg.home}/storage/framework/sessions"
        "${cfg.home}/storage/framework/testing"
        "${cfg.home}/storage/framework/views"
        "${cfg.home}/storage/logs"
      ]
      ++ [
        "f ${cfg.home}/storage/logs/laravel.log 0750 ${cfg.user} ${cfg.group} - -"
      ];
  });
}
