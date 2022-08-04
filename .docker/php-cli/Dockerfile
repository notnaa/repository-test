FROM php:7.4-cli

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN apt-get update -yqq \
    && apt-get install git zlib1g-dev libsqlite3-dev libzip-dev -y \
    && apt-get install curl \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && curl -sS https://getcomposer.org/installer | php -- \
         --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/wisebits
COPY . .
CMD bash -c "composer install --no-progress --no-interaction && /var/www/wisebits/vendor/bin/phpunit"