FROM php:5.6.35-fpm-jessie
MAINTAINER zjj <57305595@qq.com>
EXPOSE 9000


COPY ./conf/php-fpm.conf /usr/local/etc/php/php-fpm.conf
COPY ./conf/php.ini /usr/local/etc/php/php.ini

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
        libgmp-dev\
    && ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/local/include/ \
    && docker-php-ext-configure gmp \
    && docker-php-ext-install -j$(nproc) gmp \
    && docker-php-ext-install -j$(nproc) iconv mcrypt \
	&& docker-php-ext-configure gd  --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
	&& docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install soap mysql mysqli pdo_mysql opcache\
    && curl -sS https://getcomposer.org/installer | php \
    && mv /var/www/html/composer.phar /usr/local/bin/composer \
    && composer config -g repo.packagist composer https://packagist.phpcomposer.com

# pecl貌似被墙了,http://pecl.php.net/ 要包自己下
RUN curl 'http://pecl.php.net/get/redis-2.2.5.tgz' -o redis.tgz \
    && pecl install redis.tgz \

    && curl  'http://pecl.php.net/get/xdebug-2.2.2.tgz' -o xdebug.tgz \
	&& pecl install xdebug.tgz \

	&& curl  'http://pecl.php.net/get/swoole-2.0.6.tgz' -o swoole.tgz \
    && pecl install swoole.tgz \

	&& docker-php-ext-enable redis xdebug swoole gmp



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


RUN cd /var/www/html/ \
    && rm -rf redis.tgz  scws-1.2.3  scws.tar.bz2  xdebug.tgz \
    && mkdir /etc/php-fpm.d/