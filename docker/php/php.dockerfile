FROM php:8.2-fpm

RUN apt-get update \
 && apt-get install -y --no-install-recommends \
 && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev \
 && docker-php-ext-configure gd --with-jpeg --with-freetype \
 && docker-php-ext-install pdo pdo_mysql \
 && if ! php -m | grep -q 'redis'; then \
     pecl install redis && docker-php-ext-enable redis; \
 fi

WORKDIR /var/www/backend
