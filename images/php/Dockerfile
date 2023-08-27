FROM php:7.4-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev \
    mc \
    curl \
    wget \
    git \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libmcrypt-dev \
    && pecl install mcrypt-1.0.3 \
    && docker-php-ext-enable mcrypt \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*


# Install Postgre PDO
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini

WORKDIR /var/www/import_command

CMD ["php-fpm"]
