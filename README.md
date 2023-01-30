Start dev server : `symfony server:start`

OR with php dev server : `cd public && php -S localhost:8010`

> :warning: the php dev server cannot rewrite or find paths with 'dot(.)' in its name such as `localhost:8080/files/testfile.php`

Info : `https://symfony.com/doc/current/setup.html`

### Run in docker

- pull php && nginx \
  docker pull ghcr.io/brytkhalifa/ksptesterbackend-php:latest \
  docker pull ghcr.io/brytkhalifa/ksptesterbackend-nginx:latest

```yaml
cat <<EOT >> docker-compose_prod.yml
version: '3.8'
services:
  php:
    build:
      context: .
      target: app_php
      dockerfile: Dockerfile_prod
    image: ghcr.io/brytkhalifa/ksptesterbackend-php:latest
    restart: on-failure
    expose:
      - "9000"
    environment:
      APP_ENV: prod
      PHP_DATE_TIMEZONE: ${PHP_DATE_TIMEZONE:-UTC}
    volumes:
      - /ksptester/resources:/app/resources

  nginx:
    build:
      context: .
      target: app_nginx
      dockerfile: Dockerfile_prod
    image: ghcr.io/brytkhalifa/ksptesterbackend-nginx:latest
    restart: on-failure
    depends_on:
      - php
    ports:
      - "8010:80"
EOT
```

docker-compose -f docker-compose_prod.yml up -d
