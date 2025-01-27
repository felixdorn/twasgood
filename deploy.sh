ssh heidegger <<EOF
docker pull "rg.fr-par.scw.cloud/forevue/twasgood:$1"
docker stop twasgood
docker rm twasgood
docker run --name twasgood --network host --restart unless-stopped -d -v /run/secrets/imgproxy-salt-key:/run/secrets/imgproxy-salt-key -v /run/secrets/imgproxy-enc-key:/app/run/secrets/imgproxy-enc-key  -v /run/secrets/twasgood-env-file:/var/lib/twasgood/.env  -d "rg.fr-par.scw.cloud/forevue/twasgood:$1"
EOF
