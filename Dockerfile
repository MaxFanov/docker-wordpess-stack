ARG PHP_VERSION=latest
FROM wordpress:${PHP_VERSION}-fpm-alpine

RUN apk add --no-cache $PHPIZE_DEPS shadow \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del $PHPIZE_DEPS

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html