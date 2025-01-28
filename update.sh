set -ex

CODEDIR=$(pwd)

NODEDIR=$(mktemp -d)
trap 'rm -rf -- "$NODEDIR"' EXIT

cp "$CODEDIR"/package.json "$NODEDIR"

cd $NODEDIR

node2nix --composition node-composition.nix

cp "$NODEDIR"/* "$CODEDIR"


cd "$CODEDIR"

BASEDIR=$(mktemp -d)
trap 'rm -rf -- "$BASEDIR"' EXIT

cp composer.json "$BASEDIR"
cp composer.lock "$BASEDIR"
cp default.nix "$BASEDIR"

cd $BASEDIR

"$CODEDIR"/vendor/bin/composer2nix --name "twasgood" \
  --composition=composition.nix \
  --no-dev

rm composer.json composer.lock

# change version number
sed -e "s/version =.*;/version = \"$1\";/g" -i ./default.nix

# fix composer-env.nix
sed -e "s/stdenv\.lib/lib/g" \
    -e '3s/stdenv, writeTextFile/stdenv, lib, writeTextFile/' \
    -i ./composer-env.nix

# fix composition.nix
sed -e '7s/stdenv writeTextFile/stdenv lib writeTextFile/' \
    -i composition.nix

cp "$BASEDIR"/* "$CODEDIR"

cd "$CODEDIR"

nix build .#default

exit $?
