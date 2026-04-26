FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/bin/composer

WORKDIR /var/www/html

COPY . .
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
RUN composer install
USER www-data

EXPOSE 9000
CMD ["php-fpm"]
