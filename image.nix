{ pkgs ? import <nixpkgs> { system = "x86_64-linux"; }, version ? "latest" }:
let
  customPhp = (((pkgs.php84.override {
    # Sapi flags
    cgiSupport = false;
    cliSupport = true;
    fpmSupport = false;
    pearSupport = false;
    pharSupport = true;
    phpdbgSupport = false;

    # Misc fags
    apxs2Support = false;
    argon2Support = true;
    cgotoSupport = false;
    embedSupport = true;
    ipv6Support = true;
    staticSupport = false;
    systemdSupport = false;
    valgrindSupport = false;
    zendMaxExecutionTimersSupport = true;
    zendSignalsSupport = false;
    ztsSupport = true;
  }).overrideAttrs (oldAttrs: {
    stdenv = pkgs.clangStdenv;

    # optimizations
    extraConfig = ''
      CC = "${pkgs.llvmPackages_19.clang}/bin/clang";
      CXX = "${pkgs.llvmPackages_19.clang}/bin/clang++";
      CFLAGS="$CFLAGS -march=x86-64-v3 -mtune=x86-64-v3 -O3 -ffast-math -flto"
      CXXFLAGS="$CXXFLAGS -march=x86-64-v3 -mtune=x86-64-v3 -O3 -ffast-math -flto"
      LDFLAGS="$LDFLAGS -flto"
    '';

    # Explicitly enable XML support (required by FrankenPHP)
    configureFlags = (oldAttrs.configureFlags or [ ])
      ++ [ "--enable-xml" "--with-libxml" ];

    buildInputs = (oldAttrs.buildInputs or [ ]) ++ [ pkgs.libxml2.dev ];
  })).withExtensions ({ all, ... }:
    with all; [
      sqlite3
      ctype
      curl
      dom
      exif
      fileinfo
      filter
      igbinary
      intl
      mbstring
      openssl
      pdo
      pdo_sqlite
      session
      simplexml
      tokenizer
      xmlwriter
      zip
      zlib
      opcache
      gd
      iconv
      sodium

      # Required by Octane
      pcntl
    ])).buildEnv { extraConfig = builtins.readFile ./php.ini; };

  frankenphp = (pkgs.frankenphp.override { php = customPhp; }).overrideAttrs
    (oldAttrs: {
      phpEmbedWithZts = customPhp;
      phpUnwrapped = customPhp.unwrapped;
      phpConfig = "${customPhp.unwrapped.dev}/bin/php-config";
    });

  twasgood = pkgs.callPackage ./default.nix {
    inherit pkgs;
    php = customPhp;
  };
in pkgs.dockerTools.buildImage {
  name = "rg.fr-par.scw.cloud/forevue/twasgood";
  tag = version;

  copyToRoot = pkgs.buildEnv {
    name = "root-image";
    pathsToLink = [ "/bin" "/etc" ];
    paths = [
      customPhp
      frankenphp
      pkgs.busybox
      pkgs.dockerTools.caCertificates
      pkgs.jpegoptim
      pkgs.optipng
      pkgs.pngquant
      pkgs.gifsicle
      pkgs.libavif
      (pkgs.writeShellScriptBin "twasgood" ''
        #!${pkgs.runtimeShell}
        cd ${twasgood}
        /bin/php artisan $*
      '')
    ];
  };

  runAsRoot = ''
    set -ex;

    mkdir -p /var/lib/twasgood/{storage,bootstrap-cache,public}
    mkdir -p /var/lib/twasgood/storage/{app,framework,logs}
    mkdir -p /var/lib/twasgood/storage/framework/{cache,sessions,views}

    cp -r ${twasgood}/bootstrap-cache /var/lib/twasgood/
  '';

  config = {
    Cmd = [ "/bin/twasgood" "octane:frankenphp" "--port 80" ];
    ExposedPorts = { "80/tcp" = { }; };
  };
}
