{
  stdenvNoCC,
  callPackage,
}: let
  nodeDeps = (callPackage ./npm-nix/default.nix {}).nodeDependencies;
  composerDeps = (callPackage ./composer.nix {noDev = true;});
in
  stdenvNoCC.mkDerivation {
    pname = "twasgood";
    version = "0.1.0";

    src = ./.;

    buildPhase = ''
      runHook preBuild

      mkdir -p $out/
      cp -R . $out/

      ln -s ${nodeDeps}/lib/node_modules ./node_modules
      export PATH=${nodeDeps}/bin:$PATH

      vite build
      cp -r public/build $out/

      rm -rf node_modules tests npm-nix *.nix resources/js resources/css

      runHook postBuild
    '';

    installPhase = ''
       runHook preInstall

      ln -s ${composerDeps}/vendor ./vendor

       runHook postInstall
    '';
  }
