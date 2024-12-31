{
  inputs = {
    nixpkgs.url = "github:nixos/nixpkgs/nixpkgs-unstable";
  };

  outputs = {
    self,
    nixpkgs,
  }: let
    pkgs = import nixpkgs {system = "x86_64-linux";};
    php = pkgs.php83.buildEnv {
      extraConfig = ''
        memory_limit = 1G
      '';

      extensions = exts: exts.enabled ++ (with exts.all; [xdebug]);
    };
  in {
    devShells."x86_64-linux".default = pkgs.mkShell {
      nativeBuildInputs = [
        php
        php.packages.composer
        pkgs.nodejs_23
        pkgs.pnpm
        pkgs.meilisearch
        pkgs.postgresql_16
      ];
    };
  };
}
