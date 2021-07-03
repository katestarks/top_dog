FROM php:7.4-apache

RUN docker-php-ext-install pdo pdo_mysql

RUN usermod -u 1000 www-data
RUN usermod -G staff www-data
