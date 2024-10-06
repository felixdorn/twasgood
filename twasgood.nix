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

    hostName = lib.mkOption {
      type = lib.types.str;
      description = "FQDN for the twasgood instance";
    };

    home = lib.mkOption {
      type = lib.types.str;
      default = "/var/lib/twasgood";
      description = "Storage path for twasgood";
    };

    phpPackage = lib.mkPackageOption pkgs "php" {
      example = "php83";
      default = pkgs.php83.buildEnv {
        extensions = exts: exts.enabled ++ (with exts.all; [swoole gd exif]);
      };
    };

    configFile = lib.mkOption {
      type = lib.types.str;
      description = "A path to the dotenv file which configures Laravel";
    };
  };

  config = lib.mkIf cfg.enable {
    users.users.twasgood = {
      home = "${cfg.home}";
      group = "twasgood";
      isSystemUser = true;
    };
    users.groups.twasgood.members = ["twasgood" "traefik"];

    systemd.services = {
      twasgood-setup = {
        wantedBy = ["multi-user.target"];
        before = ["twasgood.service"];
        script = let
          php = cfg.phpPackage;
        in ''
          ${php}/bin/php artisan optimize:clear
          ${php}/bin/php artisan optimize
        '';
      };
    };

    systemd.tmpfiles.rules =
      map (dir: "d ${dir} 0750 twasgood twasgood - -") [
        "${cfg.home}"
        "${cfg.home}/storage"
        "${cfg.home}/storage/app/public"
        "${cfg.home}/storage/framework/cache/data"
        "${cfg.home}/storage/framework/sessions"
        "${cfg.home}/storage/framework/testing"
        "${cfg.home}/storage/framework/views"
        "${cfg.home}/storage/logs"
      ]
      ++ [
        "f ${cfg.home}/storage/logs/laravel.log 0750 twasgood twasgood - -"
      ];
  };
}
