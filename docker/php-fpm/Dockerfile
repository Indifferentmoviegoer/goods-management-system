FROM php:8.1.5-fpm-bullseye as php_fpm_production

RUN apt update && apt install -y --no-install-recommends wget apt-transport-https gpg ca-certificates
RUN wget -O- https://mirror.yandex.ru/debian/dists/bullseye/Release.gpg | gpg --dearmor > /usr/share/keyrings/yandex.gpg
RUN echo 'deb https://mirror.yandex.ru/debian bullseye main non-free contrib' > /etc/apt/sources.list

RUN apt update && apt install -y --no-install-recommends --allow-downgrades \
    apt-utils \
    openssl \
    git \
    libzip-dev \
    libyaml-dev \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    unzip \
    curl \
    wget \
    procps \
    librabbitmq-dev \
    libpq-dev \
    zlib1g \
    zlib1g-dev \
    && apt clean

RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet && mkdir /.composer && chmod 0777 /.composer
ENV COMPOSER_MEMORY_LIMIT=-1

RUN docker-php-ext-configure zip && docker-php-ext-install zip
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install gd
RUN docker-php-ext-install intl pdo pdo_pgsql sockets opcache
RUN pecl install apcu-5.1.21 && docker-php-ext-enable --ini-name 20-apcu.ini apcu
RUN pecl install redis-5.3.4 && docker-php-ext-enable --ini-name 10-redis.ini redis
RUN pecl install amqp-1.11.0 && docker-php-ext-enable amqp
RUN pecl clear-cache

RUN mkdir -p /var/www/symfony/public/uploads

RUN cp $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini
COPY php-fpm/php.ini $PHP_INI_DIR/conf.d/php-custom.ini

WORKDIR /var/www/symfony
EXPOSE 9000

FROM php_fpm_production as php_fpm_dev

RUN pecl install xdebug-3.1.4 && docker-php-ext-enable xdebug
RUN pecl clear-cache

RUN cp $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini
COPY php-fpm/xdebug.ini $PHP_INI_DIR/conf.d/xdebug.ini

ENV PHP_IDE_CONFIG="serverName=goods-management-system"

ENTRYPOINT ["docker-php-entrypoint"]
CMD ["php-fpm"]

FROM php_fpm_dev as php_queue
ENTRYPOINT ["/var/www/symfony/bin/console", "messenger:consume", "--time-limit=3600", "-vv"]
