FROM php:7.3-fpm

RUN apt-get update && apt-get upgrade -y
RUN apt-get install -y \
    libxml2-dev \
    libwebp-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libxpm-dev \
    libfreetype6-dev

RUN docker-php-ext-configure gd \
    --with-gd \
    --with-webp-dir \
    --with-jpeg-dir \
    --with-png-dir \
    --with-zlib-dir \
    --with-xpm-dir \
    --with-freetype-dir

RUN docker-php-ext-install mysqli pdo_mysql bcmath ctype fileinfo json mbstring tokenizer xml gd intl
RUN apt-get autoremove -y && apt-get autoclean -y

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=1.10.17

RUN curl -sL https://rpm.nodesource.com/setup | bash -

RUN apt-get install -y nodejs

WORKDIR /var/www/

RUN apt-get install -y libzip-dev unzip

RUN docker-php-ext-install zip

COPY php.ini $PHP_INI_DIR/php.ini
