FROM php:8.1-fpm

WORKDIR /var/www/html

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY . /var/www/html

RUN apt update -y && apt upgrade -y && \
    apt install -y libmagickwand-dev --no-install-recommends && \
    install-php-extensions intl zip bcmath pdo_mysql pcntl \
    gmp opcache uuid amqp json_post imagick apcu \
    igbinary ast redis xdebug mongodb

RUN composer install --optimize-autoloader --apcu-autoloader --ignore-platform-reqs

CMD ["php-fpm"]