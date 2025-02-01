set -ex

CODEDIR=$(pwd)

TMPDIR=$(mktemp -d)
trap 'rm -rf -- "$TMPDIR"' EXIT

cp "$CODEDIR"/package.json "$TMPDIR"

cd $TMPDIR

node2nix -18 --composition node-composition.nix

cp "$TMPDIR"/* "$CODEDIR"/nix

cd "$CODEDIR"

TMPDIR=$(mktemp -d)
trap 'rm -rf -- "$TMPDIR"' EXIT

cp "$CODEDIR"/composer.json "$TMPDIR"
cp "$CODEDIR"/composer.lock "$TMPDIR"
cp "$CODEDIR"/default.nix "$TMPDIR"

cd $TMPDIR

"$CODEDIR"/vendor/bin/composer2nix \
  --name "twasgood" \
  --composition=php-composition.nix \
  --no-dev \

rm composer.json composer.lock

# change version number
sed -e "s/version =.*;/version = \"$1\";/g" -i ./default.nix

# fix composer-env.nix
sed -e "s/stdenv\.lib/lib/g" \
    -e '3s/stdenv, writeTextFile/stdenv, lib, writeTextFile/' \
    -i ./composer-env.nix

# fix composition.nix
sed -e '7s/stdenv writeTextFile/stdenv lib writeTextFile/' \
    -i ./php-composition.nix

cp "$TMPDIR"/* "$CODEDIR"/nix

cd "$CODEDIR"

nix build .#default

exit $?
