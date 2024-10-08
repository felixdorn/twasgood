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

    src = builtins.path {
      path = ./.;
      name = "twasgood";
    };

    patchPhase = "";

    fixupPhase = "";

    buildPhase = ''
      runHook preBuild

      cp -r ${composerDeps}/vendor ./vendor

      chmod -R +w ./vendor

      find ./vendor/ -iwholename "*laravel*/*.php" -print -type f -exec sed -i -e "s/bootstrap\/app.php/app\/bootstrap.php/g" -e "s/bootstrapPath('app.php')/bootstrapPath('${""}''${out//\//\\/}\/app\/bootstrap.php')/g" {} \;

      sed -i 's/bootstrap\/app.php/app\/bootstrap.php/g' artisan
      sed -i 's/bootstrap\/app.php/app\/bootstrap.php/g' public/index.php

      ln -s ${nodeDeps}/lib/node_modules ./node_modules
      export PATH=${nodeDeps}/bin:$PATH

      vite build

      rm -rf node_modules

      runHook postBuild
    '';

    installPhase = ''
      runHook preInstall

      mkdir -p $out/
      cp -r composer.json app/ routes/ vendor/ resources/ bootstrap/ database/ lang/ public/ artisan config/ $out/
      cp $out/bootstrap/app.php $out/app/bootstrap.php

      runHook postInstall
    '';
  }
