FROM php:8.2-fpm

RUN apt update \
    && apt install -y zlib1g-dev g++ libicu-dev zip libzip-dev zip gnupg2 libpq-dev \
    && docker-php-ext-install intl opcache pdo \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && apt update \
    && docker-php-ext-install mysqli pdo pdo_mysql  \
    && docker-php-ext-enable pdo_mysql

WORKDIR /var/www

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && apt-get upgrade -y && apt-get install -y zlib1g-dev libpng-dev libjpeg-dev libfreetype6-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install gd

RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
    echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list && \
    apt-get update && apt-get install -y yarn
