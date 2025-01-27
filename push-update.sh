set -ex


docker load <$(nix-build image.nix --argstr version "$1")
docker push "rg.fr-par.scw.cloud/forevue/twasgood:$1"

./deploy.sh "$1"
