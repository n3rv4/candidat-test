ARG APP_ENV=dev

FROM php:8.2-fpm-alpine

RUN apk update && apk add --no-cache \
		acl \
		fcgi \
		file \
		gettext \
		git \
		gnu-libiconv \
		postgresql-dev \
    	bash-completion \
    	curl \
    	sudo \
	;

ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so

ARG APCU_VERSION=5.1.22
RUN set -eux; \
    apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        coreutils \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        libzip-dev \
        zlib-dev \
        linux-headers \
        icu-dev \
    ; \
    \
    docker-php-ext-configure gd --with-freetype --with-jpeg; \
    docker-php-ext-install -j "$(nproc)" \
        exif \
        gd \
        pcntl \
        pdo_pgsql \
        zip \
        intl \
    ; \
    pecl install \
        apcu-${APCU_VERSION} \
    ; \
    pecl install xdebug; \
    pecl clear-cache; \
    docker-php-ext-enable \
        apcu \
        opcache \
    ; \
    \
    runDeps="$( \
        scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
            | tr ',' '\n' \
            | sort -u \
            | awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
    )"; \
    apk add --no-cache --virtual .api-phpexts-rundeps $runDeps; \
    apk del .build-deps

# Install dependencies for Chrome
RUN apk update && apk add --no-cache \
      wget \
      chromium \
      chromium-chromedriver \
    ;

# Install chrome, required for the symfony/panther library
ENV PANTHER_NO_SANDBOX 1
# Not mandatory, but recommended
ENV PANTHER_CHROME_ARGUMENTS='--headless --no-sandbox --disable-infobars --disable-dev-shm-usage --disable-gpu --disable-extensions --remote-debugging-port=9222'

# Create a symbolic link to the Chrome binary
RUN ln -s /usr/bin/chromium-browser /usr/bin/google-chrome-stable

ARG APP_ENV
COPY ./devops/php/conf.d/php.${APP_ENV}.ini /usr/local/etc/php/php.ini
COPY ./devops/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/99-xdebug.ini

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1

ENV PATH="${PATH}:/root/.composer/vendor/bin"

VOLUME /app
WORKDIR /app

CMD ["php-fpm"]
