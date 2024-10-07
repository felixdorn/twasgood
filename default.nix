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
      cp -r . $out/

      #cp -r app/ routes/ resources/ bootstrap/ database/ lang/ public/ artisan config/ $out/
      #rm -rf $out/resources/css $out/resources/js

      runHook postInstall
    '';
  }
