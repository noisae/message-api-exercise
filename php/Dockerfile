FROM php:7.1.8-apache

RUN apt-get update && apt-get install git -y
RUN a2enmod rewrite
RUN docker-php-ext-install pdo_mysql
