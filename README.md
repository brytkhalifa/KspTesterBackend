Start dev server : `symfony server:start`

Info : `https://symfony.com/doc/current/setup.html`


### Run in docker
docker pull ghcr.io/brytkhalifa/ksptesterbackend-php:latest
docker pull ghcr.io/brytkhalifa/ksptesterbackend-nginx:latest
docker-compose -f docker-compose_prod.yml build
docker-compose -f docker-compose_prod.yml up -d