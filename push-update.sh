set -ex


docker build -t "rg.fr-par.scw.cloud/forevue/twasgood:$1" .
docker push "rg.fr-par.scw.cloud/forevue/twasgood:$1"

./deploy.sh "$1"
