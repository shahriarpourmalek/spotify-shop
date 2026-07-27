# syntax=docker/dockerfile:1.7

ARG PHP_VERSION=8.4
FROM composer:2 AS composer-bin

FROM php:${PHP_VERSION}-fpm-alpine AS app

ARG APP_USER=laravel
ARG APP_UID=1000
ARG APP_GID=1000
ARG TIMEZONE=UTC

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/tmp/composer \
    TZ=${TIMEZONE}

WORKDIR /var/www/html

# Runtime packages and build dependencies are kept in separate virtual groups so
# build-only packages can be removed after PHP extensions are compiled.
RUN apk add --no-cache \
        bash \
        curl \
        freetype \
        git \
        icu-libs \
        libjpeg-turbo \
        libpng \
        libwebp \
        libxpm \
        libzip \
        nano \
        oniguruma \
        shadow \
        unzip \
        zip \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        freetype-dev \
        icu-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        libwebp-dev \
        libxpm-dev \
        libzip-dev \
        linux-headers \
        oniguruma-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
        --with-xpm \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        exif \
        gd \
        intl \
        mbstring \
        mysqli \
        opcache \
        pcntl \
        pdo_mysql \
        sockets \
        zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps \
    && rm -rf /tmp/pear ~/.pearrc /var/cache/apk/*

COPY --from=composer-bin /usr/bin/composer /usr/bin/composer

RUN groupadd --gid "${APP_GID}" "${APP_USER}" \
    && useradd --uid "${APP_UID}" --gid "${APP_GID}" --create-home --shell /bin/sh "${APP_USER}"

# Copy Composer manifests first to maximize cache reuse when application files change.
COPY --chown=${APP_USER}:${APP_USER} composer.json composer.lock* ./
RUN if [ -f composer.json ]; then \
        composer install \
            --no-dev \
            --no-interaction \
            --no-progress \
            --prefer-dist \
            --no-autoloader \
            --no-scripts; \
    fi

COPY --chown=${APP_USER}:${APP_USER} . .
RUN if [ -f composer.json ]; then \
        composer dump-autoload --optimize --no-dev --no-interaction; \
    fi \
    && mkdir -p storage bootstrap/cache \
    && chown -R "${APP_USER}:${APP_USER}" storage bootstrap/cache

USER ${APP_USER}

EXPOSE 9000

CMD ["php-fpm"]
