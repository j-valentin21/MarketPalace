FROM php:7.4.12-fpm-alpine

RUN mkdir -p /var/www/html

RUN apk --no-cache add shadow && usermod -u 1000 www-data

RUN apk add nano

RUN set -xe \
    && apk add --no-cache --update --virtual .phpize-deps $PHPIZE_DEPS \
    && pecl install -o -f redis  \
    && echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini \
    && rm -rf /usr/share/php \
    && rm -rf /tmp/*

RUN apk add --no-cache bash curl vim zip \
    zlib-dev \
    php7-zlib \
    libpng-dev \
    libjpeg-turbo \
    libjpeg-turbo-dev

RUN docker-php-ext-configure gd --enable-gd --with-jpeg

RUN docker-php-ext-install pdo pdo_mysql gd
