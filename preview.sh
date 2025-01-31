set -ex


if [ "$1" != "--skip-build" ];
then
    docker load <$(nix-build image.nix --argstr version "preview")
    docker push "rg.fr-par.scw.cloud/forevue/twasgood:preview"
fi

ssh descartes <<EOF
    docker pull "rg.fr-par.scw.cloud/forevue/twasgood:preview"
    docker stop twasgood-preview
    docker rm twasgood-preview
    docker run --name twasgood-preview -p 5000:80 --restart unless-stopped -v /run/secrets/twasgood-env-file:/var/lib/twasgood/.env -v /var/lib/twasgood/database.sqlite:/var/lib/twasgood/database.sqlite  -d rg.fr-par.scw.cloud/forevue/twasgood:preview
EOF
