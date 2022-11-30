FROM php:8.1.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y mariadb-client git libicu-dev \
    libzip-dev zip unzip libpng-dev libjpeg-dev libxpm-dev libwebp-dev libjpeg62-turbo-dev libfreetype6-dev \
    libmagickwand-dev libpq-dev --no-install-recommends \
    && pecl install xdebug imagick \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && docker-php-ext-install opcache \
    && docker-php-ext-install bcmath \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-enable imagick \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
