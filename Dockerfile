FROM php:8.0-fpm

# Install the PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql
