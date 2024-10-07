{
  stdenvNoCC,
  callPackage,
}: let
  nodeDeps = (callPackage ./npm-nix/default.nix {}).nodeDependencies;
  composerDeps = callPackage ./composer.nix {noDev = true;};
in
  stdenvNoCC.mkDerivation {
    pname = "twasgood";
    version = "0.1.0";

    src = ./.;

    buildPhase = ''
      runHook preBuild

      ls -r

      ln -s ${nodeDeps}/lib/node_modules ./node_modules
      export PATH=${nodeDeps}/bin:$PATH

      vite build

      rm -rf node_modules

      runHook postBuild
    '';

    installPhase = ''
      runHook preInstall

      mkdir -p $out/

      cp -r ${composerDeps}/vendor $out/vendor
      cp -r composer.json app/ routes/ resources/ bootstrap/ database/ lang/ public/ artisan config/ $out/
      cp $out/bootstrap/app.php $out/app/bootstrap.php

      substituteInPlace ./**/*.php --replace 'bootstrap/app.php' 'app/bootstrap.php'

      runHook postInstall
    '';
  }
