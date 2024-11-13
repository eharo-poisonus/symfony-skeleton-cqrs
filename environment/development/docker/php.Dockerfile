FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libxml2-dev \
    libssl-dev \
    libcurl4-openssl-dev \
    unzip \
    git \
    wget \
    build-essential \
    cmake \
    && docker-php-ext-install pdo pdo_mysql

RUN wget https://github.com/alanxz/rabbitmq-c/archive/refs/tags/v0.11.0.tar.gz -O rabbitmq-c.tar.gz \
    && tar -xf rabbitmq-c.tar.gz \
    && cd rabbitmq-c-0.11.0 \
    && mkdir build && cd build \
    && cmake .. \
    && make && make install \
    && cd ../.. && rm -rf rabbitmq-c-0.11.0 rabbitmq-c.tar.gz \
    && pecl install amqp \
    && docker-php-ext-enable amqp

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . .

RUN cp .env.dev .env

RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader --ignore-platform-req=ext-openswoole

USER 1000