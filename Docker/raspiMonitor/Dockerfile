FROM php:7.3.7-fpm-buster

RUN apt-get update && \
apt-get install iproute2 nodejs npm openssh-server git zip unzip -y

WORKDIR /tmp
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

RUN docker-php-ext-install pdo_mysql
RUN pecl install xdebug

COPY ./Docker/raspiMonitor/xdebug.ini /usr/local/etc/php/conf.d/