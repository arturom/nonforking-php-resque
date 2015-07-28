FROM ubuntu:trusty

MAINTAINER Arturo Mejia <arturo.mejia@kreatetechnology.com>

RUN apt-get update && apt-get install -y \
    curl\
    git\
    php5\
    supervisor\
    vim
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

WORKDIR /root/app

EXPOSE 8000
