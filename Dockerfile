FROM node:23-alpine3.21@sha256:f2f8fc3620ff636de73129f9a3a20c5366ce96bbe08f41d54ed158196efa7a9c AS build
COPY package.json pnpm-lock.yaml /build/
WORKDIR /build
RUN npm install -g pnpm@9.15.1 && pnpm install
COPY . .
RUN rm -rf public/hot && pnpm run build

FROM php:8.4-alpine

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

RUN install-php-extensions pdo pdo_pgsql pcntl sockets sodium

COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

WORKDIR  /app

COPY --from=build /build /app

RUN composer install --no-dev --no-interaction --no-ansi && php artisan octane:install --server=roadrunner

CMD ["php", "artisan", "octane:start", "--port=5000"]

