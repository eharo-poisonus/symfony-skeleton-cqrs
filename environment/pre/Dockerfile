FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libxml2-dev \
    libssl-dev \
    libcurl4-openssl-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql

RUN pecl install openswoole \
    && docker-php-ext-enable openswoole

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . .

RUN cp .env.pre .env

RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader

EXPOSE 9501

CMD ["php", "public/server.php"]

HEALTHCHECK --interval=10s --timeout=8s --start-period=20s --retries=3 \
    CMD curl http://localhost:9501/health || exit 1