{
  inputs = { nixpkgs.url = "github:nixos/nixpkgs/nixpkgs-unstable"; };

  outputs = { self, nixpkgs, }:
    let
      pkgs = import nixpkgs { system = "x86_64-linux"; };
      php = pkgs.php84.buildEnv {
        extraConfig = ''
          memory_limit = 1G
          upload_max_filesize = 100M
          post_max_size = 150M
        '';
      };

      twasgood = pkgs.callPackage ./. { inherit pkgs php; };
    in {
      packages."x86_64-linux".default = twasgood;
      packages."x86_64-linux".image =
        pkgs.callPackage ./image.nix { inherit pkgs twasgood; };
      devShells."x86_64-linux".default = pkgs.mkShell {
        nativeBuildInputs = [
          php
          php.packages.composer
          pkgs.nodejs_23
          pkgs.pnpm
          pkgs.node2nix
          pkgs.meilisearch
          pkgs.sqlite

          # For medialibrary
          pkgs.jpegoptim
          pkgs.optipng
          pkgs.pngquant
          pkgs.gifsicle
          pkgs.libavif
        ];
      };
    };
}
