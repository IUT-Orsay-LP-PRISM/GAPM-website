FROM php:8.0-apache
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
RUN cp /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/

RUN apt update \
    && apt install -y zlib1g-dev g++ git zip libzip-dev libicu-dev zip default-libmysqlclient-dev \
    && apt install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_mysql intl \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug
