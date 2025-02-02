{ pkgs, stdenvNoCC, dataDir ? "/var/lib/twasgood", php }:

let
  nodeDeps = (import ./node-composition.nix {
    inherit pkgs;
    system = "x86_64-linux";
    nodejs = pkgs.nodejs_23;
  }).nodeDependencies;
  composerDeps = import ./php-composition.nix {
    inherit pkgs php;
    inherit (stdenvNoCC.hostPlatform) system;
    noDev = true;
  };
in stdenvNoCC.mkDerivation {
  pname = "twasgood-full";
  version = "211";

  buildPhase = ''
    runHook preBuild
    cp -r ${composerDeps}/vendor vendor

    ln -s ${nodeDeps}/lib/node_modules ./node_modules
    export PATH=${nodeDeps}/bin:$PATH
    rm -rf public/build public/hot
    vite build
    rm -rf node_modules

    runHook postBuild
  '';

  installPhase = ''
    runHook preInstall

    mkdir -p $out
    cp -r composer.json app/ routes/ vendor/ resources/ bootstrap/ database/ lang/ public/ artisan config/ $out/
    ln -s ${dataDir}/.env $out/.env
    ln -s ${dataDir}/storage $out/storage
    ln -s ${dataDir}/public/ $out/public/

    cp -r $out/bootstrap/cache $out/bootstrap-cache
    rm -rf $out/bootstrap/cache
    ln -s ${dataDir}/bootstrap-cache $out/bootstrap/cache

    runHook postInstall
  '';

  src = builtins.path {
    path = ./.;
    name = "twasgood-source";
  };
}
