FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    bash curl git icu-dev icu-libs libpq-dev libzip-dev oniguruma-dev nodejs npm $PHPIZE_DEPS \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo pdo_pgsql zip opcache \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del --no-cache icu-dev $PHPIZE_DEPS

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY docker/php/local.ini /usr/local/etc/php/conf.d/local.ini
COPY docker/php/entrypoint.sh /usr/local/bin/construpro-entrypoint

RUN chmod +x /usr/local/bin/construpro-entrypoint

EXPOSE 9000

CMD ["construpro-entrypoint"]
