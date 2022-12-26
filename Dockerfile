# Dockerfile
FROM php:8.1.8-cli

RUN apt-get update -y && apt-get install -y libmcrypt-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# #RUN docker-php-ext-install pdo mbstring
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN   mv /root/.symfony5/bin/symfony /usr/local/bin/symfony
WORKDIR /app
COPY . /app

RUN composer install

#RUN composer require server --dev

EXPOSE 8000
CMD symfony server:start 