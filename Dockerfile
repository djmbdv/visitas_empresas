FROM php:7.4-apache

RUN docker-php-ext-install pdo_mysql

RUN apt-get update && \
     apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libzip-dev  libsodium-dev && \
     docker-php-ext-configure gd && \
     docker-php-ext-install gd && \
     docker-php-ext-install zip  && \
     docker-php-ext-install sodium

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN a2enmod rewrite
RUN apt-get clean