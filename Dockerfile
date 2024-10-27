FROM ghcr.io/devgine/composer-php:latest

ADD . /code

WORKDIR /code

RUN apk add --no-cache bash

RUN composer install
