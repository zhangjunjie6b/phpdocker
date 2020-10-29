FROM php:7.2.13-fpm
RUN apt-get update
RUN apt-get install -y \
        libfreetype6-dev \
		libjpeg62-turbo-dev \
		libmcrypt-dev \
		libpng-dev \
        libxml2-dev \
        libmagickwand-dev \
        libmagickcore-dev \
        libgmp-dev \
        libzip-dev \
        libevent-dev \
     && docker-php-ext-configure gd --with-freetype --with-jpeg \
     && docker-php-ext-install -j$(nproc) gd \
     && docker-php-ext-install -j$(nproc) bcmath mysqli pdo_mysql opcache \
     && curl -sS https://getcomposer.org/installer | php \
     && mv /var/www/html/composer.phar /usr/local/bin/composer \
     && composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/


RUN pecl install redis-5.3.2  \
    && pecl install swoole-4.4.8 \
    && pecl install imagick-3.4.4 \
    && pecl install grpc-1.33.1 \
    && pecl install zip \
    && docker-php-ext-enable imagick redis swoole grpc zip
