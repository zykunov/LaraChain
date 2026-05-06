FROM php:8.3-fpm-alpine

# Установка зависимостей
RUN apk add --no-cache \
git \
curl \
libpng-dev \
libzip-dev \
freetype-dev \
libjpeg-turbo-dev \
libwebp-dev \
icu-dev \
libc-dev \
make \
g++

# Установка PHP-расширений
RUN docker-php-ext-install gd \
&& docker-php-ext-install pdo_mysql \
&& docker-php-ext-install zip \
&& docker-php-ext-install intl \
&& docker-php-ext-install bcmath \
&& docker-php-ext-install sockets


# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Настройка прав
RUN addgroup -g 1000 www && \
adduser -u 1000 -G www -s /bin/sh -D www

USER www
WORKDIR /var/www/html

EXPOSE 9000
CMD ["php-fpm"]
