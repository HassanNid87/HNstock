FROM php:8.1-fpm-alpine

WORKDIR /var/www/app/HNstock

RUN apk update && apk add \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip

RUN docker-php-ext-install pdo pdo_mysql \
    && apk --no-cache add nodejs npm

RUN apk add git

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

USER root

RUN chmod 777 -R /var/www/app
