FROM php:8.0-fpm
RUN docker-php-ext-install mysqli pdo pdo_mysql
WORKDIR /var/www/html