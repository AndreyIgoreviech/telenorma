FROM php:8.1-rc-apache

# Apache php
COPY ./configs/server-name.conf /etc/apache2/conf-enabled/server-name.conf

# Config vhosts
COPY ./configs/vhost.conf /etc/apache2/sites-enabled/site.conf

# Config php
COPY ./configs/extra-php.ini /usr/local/etc/php/conf.d/extra-php.ini

RUN service apache2 restart
