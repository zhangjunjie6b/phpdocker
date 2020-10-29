FROM php:7.1-fpm-jessie



RUN mv /etc/apt/sources.list /etc/apt/sources.list.bak && \
echo 'deb http://mirrors.163.com/debian/ jessie main non-free contrib' > /etc/apt/sources.list && \
echo 'deb http://mirrors.163.com/debian/ jessie-updates main non-free contrib' >> /etc/apt/sources.list && \
echo 'deb http://mirrors.163.com/debian-security/ jessie/updates main non-free contrib' >> /etc/apt/sources.list

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
    && ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/local/include/ \
    && docker-php-ext-configure gmp \
    && docker-php-ext-install -j$(nproc) gmp \
    && docker-php-ext-install -j$(nproc) iconv mcrypt \
	&& docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
	&& docker-php-ext-install -j$(nproc) gd

# pecl貌似被墙了,http://pecl.php.net/ 要包自己下
RUN curl 'http://pecl.php.net/get/redis-4.0.2.tgz' -o redis.tgz  \
    && pecl install redis.tgz \
	&& curl  'http://pecl.php.net/get/xdebug-2.6.0.tgz' -o xdebug.tgz \
    && pecl install xdebug.tgz \
    && curl  'http://pecl.php.net/get/swoole-4.0.2.tgz' -o swoole.tgz \
    && pecl install swoole.tgz \
    && curl 'http://pecl.php.net/get/imagick-3.4.3.tgz' -o imagick.tgz\
    && pecl install imagick.tgz \
    && docker-php-ext-enable imagick redis xdebug swoole gmp

RUN docker-php-ext-install mysqli pdo_mysql opcache\
    && curl -sS https://getcomposer.org/installer | php \
    && mv /var/www/html/composer.phar /usr/local/bin/composer \
    && composer config -g repo.packagist composer https://packagist.phpcomposer.com


#安装分词
RUN curl 'http://www.xunsearch.com/scws/down/scws-1.2.3.tar.bz2' -o scws.tar.bz2 \
    && tar xvjf scws.tar.bz2 \
    && cd scws-1.2.3 \
    && ./configure --prefix=/usr/local/scws \
    && make \
    && make install \
    && cd phpext \
    && phpize \
    && ./configure --with-scws=/usr/local/scws \
    && make \
    && make install \
    && cd ../../ \
    && rm -rf scws scws-1.2.3.tar.bz2 \
    && docker-php-ext-enable scws \
    && echo "scws.default.charset = utf8" >> /usr/local/etc/php/conf.d/docker-php-ext-scws.ini \
    && echo "scws.default.fpath = /usr/local/scws/etc" >> /usr/local/etc/php/conf.d/docker-php-ext-scws.ini

#pcntl 安装

RUN cd /usr/src/ \
    && mkdir /usr/src/php \
    && tar -xvf php.tar.xz -C ./php\
    && cd /usr/src/php \
    && mv * php7 \
    && cd /usr/src/php/php7/ext/pcntl \
    && phpize \
    && ./configure --with-php-config=/usr/local/bin/php-config \
    &&  make && make install \
    && docker-php-ext-enable pcntl



RUN cd /var/www/html/ \
    && rm -rf redis.tgz  scws-1.2.3  scws.tar.bz2  xdebug.tgz \
    && mkdir /etc/php-fpm.d/

#xdebug配置
RUN echo "xdebug.remote_host= 10.0.1.1 \n xdebug.remote_port = 9123 \n xdebug.idekey = PHPSTORM \n xdebug.remote_log='/www/xdebug_php7.log' \n xdebug.remote_enable = 1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
