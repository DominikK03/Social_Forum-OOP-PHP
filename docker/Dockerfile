FROM php:8.3.8-fpm

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www