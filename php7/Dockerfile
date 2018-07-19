FROM php:7.1-fpm-jessie



# pecl貌似被墙了,http://pecl.php.net/ 要包自己下
RUN curl 'http://pecl.php.net/get/redis-4.0.2.tgz' -o redis.tgz  \
    && pecl install redis.tgz \
	&& curl  'http://pecl.php.net/get/xdebug-2.6.0.tgz' -o xdebug.tgz \
    && pecl install xdebug.tgz \
    && curl  'http://pecl.php.net/get/swoole-4.0.2.tgz' -o swoole.tgz \
    && pecl install swoole.tgz \
    && docker-php-ext-enable redis xdebug swoole

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


RUN cd /var/www/html/ \
    && rm -rf redis.tgz  scws-1.2.3  scws.tar.bz2  xdebug.tgz \
    && mkdir /etc/php-fpm.d/