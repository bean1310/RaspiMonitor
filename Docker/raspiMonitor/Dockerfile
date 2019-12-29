FROM php:7.3.7-fpm-buster

RUN apt-get update && \
apt-get install iproute2 nodejs npm openssh-server git zip unzip -y

WORKDIR /tmp
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'baf1608c33254d00611ac1705c1d9958c817a1a33bce370c0595974b342601bd80b92a3f46067da89e3b06bff421f182') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

RUN docker-php-ext-install pdo_mysql
RUN pecl install xdebug

COPY ./Docker/raspiMonitor/xdebug.ini /usr/local/etc/php/conf.d/
