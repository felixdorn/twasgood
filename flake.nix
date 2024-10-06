{
  inputs = {
    nixpkgs.url = "github:nixos/nixpkgs/nixpkgs-unstable";
    composer2nix.url = "github:felixdorn/composer2nix";
  };

  outputs = {
    self,
    nixpkgs,
    ...
  }: let
    pkgs = nixpkgs.legacyPackages."x86_64-linux";
    php = pkgs.php83.buildEnv {
      extraConfig = ''
        memory_limit = 1G
      '';

      extensions = exts: exts.enabled ++ (with exts.all; [xdebug]);
    };

    composer2nix = self.inputs.composer2nix.packages."x86_64-linux".default;
  in {
    devShells."x86_64-linux".default = pkgs.mkShell {
      nativeBuildInputs = with pkgs; [nodejs_18 node2nix composer2nix] ++ [php php.packages.composer];
    };

    packages."x86_64-linux".default = pkgs.callPackage (import ./default.nix) {};

    nixosModules.default = import ./twasgood.nix;
  };
}
