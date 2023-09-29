FROM php:8.2-fpm-alpine

RUN apk add --no-cache curl npm build-base zlib-dev autoconf bash zip unzip libzip-dev libpng-dev

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod 777 /usr/local/bin/install-php-extensions
RUN docker-php-ext-install pdo_mysql zip gd
RUN rm /usr/local/bin/install-php-extensions

RUN docker-php-ext-install exif
RUN docker-php-ext-configure exif \
            --enable-exif


WORKDIR /app

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

EXPOSE 9000
