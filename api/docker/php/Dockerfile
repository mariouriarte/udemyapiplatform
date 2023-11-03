ARG USERID

FROM php:8.2-fpm-alpine3.18 as base

ARG USERID=1000
ARG groupid=1001
ARG UNAME=www-data
ARG UGROUP=www-data

# Create user with same permissions as host and some useful stuff
RUN adduser -u $USERID --disabled-password --gecos "" appuser

RUN mkdir /home/appuser/.ssh
RUN chown -R appuser:appuser /home/appuser/
RUN echo "StrictHostKeyChecking no" >> /home/appuser/.ssh/config
RUN echo "export COLUMNS=300" >> /home/appuser/.bashrc
RUN echo "alias sf=/appdata/www/bin/console" >> /home/appuser/.bashrc

# Install some global packages
RUN apk add --no-cache bash git jq moreutils openssh rsync yq wget zip

# Install GD
RUN set -ex \
    && apk add --no-cache freetype-dev libjpeg-turbo-dev libpng-dev libzip-dev zlib-dev autoconf build-base \
    && docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install zip

# Install Intl
RUN set -ex \
    && apk add icu-dev \
    && docker-php-ext-configure intl && docker-php-ext-install intl

# Install PostgreSQL
#RUN apk add --no-cache postgresql-dev
RUN set -ex \
	&& apk --no-cache add postgresql-libs postgresql-dev \
	&& docker-php-ext-install pgsql pdo_pgsql \
	&& apk del postgresql-dev

# Install PCOV
RUN pecl install pcov && docker-php-ext-enable pcov

# Install opcache
RUN docker-php-ext-install opcache

# Install rabbitmq
RUN apk --no-cache add build-base \
        autoconf \
        rabbitmq-c-dev
RUN pecl install amqp
RUN docker-php-ext-enable amqp

# Install and update composer
RUN curl https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer \
    && composer self-update

COPY docker/php/php.ini /usr/local/etc/php/php.ini

RUN apk --no-cache add shadow

USER root

RUN mkdir -p /appdata/www
WORKDIR /appdata/www

RUN usermod -a -G www-data appuser
RUN usermod -a -G www-data root

RUN mkdir -p /appdata/www/var/log
RUN mkdir -p /appdata/www/var/cache
RUN mkdir -p /appdata/www/var/sessions
RUN mkdir -p /appdata/www/var/cache/prod/jms_serializer

RUN chown -R www-data:www-data /appdata/www/var/log
RUN chown -R www-data:www-data /appdata/www/var/cache
RUN chown -R www-data:www-data /appdata/www/var/sessions
RUN chown -R www-data:www-data /appdata/www/var/cache/prod/jms_serializer

FROM base as dev

# Config XDEBUG
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS
RUN apk add --update linux-headers
RUN pecl install xdebug-3.2.2
RUN docker-php-ext-enable xdebug
RUN apk del -f .build-deps

# Config XDEBUG
COPY docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# cambio de puerto de php-fpm
RUN sed -i 's/9000/9050/' /usr/local/etc/php-fpm.d/zz-docker.conf
EXPOSE 3001
