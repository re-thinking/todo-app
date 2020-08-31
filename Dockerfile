FROM php:7.4-alpine

# Install PHP extensions
RUN docker-php-ext-install \
            pdo \
            pdo_mysql \
            bcmath \
            sockets

# Install composer
RUN  curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/bin/composer

RUN apk add --no-cache $PHPIZE_DEPS \
    rabbitmq-c-dev \
    && pecl install xdebug-2.9.1 \
    && pecl install amqp \
    && docker-php-ext-enable amqp \
    && docker-php-ext-enable xdebug

WORKDIR /app