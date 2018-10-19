FROM debian:stretch-slim
LABEL maintainer="messenger_app"

# Workaround for readline error
ENV DEBIAN_FRONTEND noninteractive

### Install system packages
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    wget \
    curl \
    acl \
    procps \
    mc \
    apt-transport-https \
    lsb-release \
    ca-certificates \
    --no-install-recommends

### Add php7.2 repo
RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php.list

### Install app packages
RUN apt-get update && apt-get install -y \
    php7.2-fpm \
    php7.2-common \
    php7.2-cli \
    php7.2-curl \
    php7.2-json \
    php7.2-mbstring \
    php7.2-opcache \
    php7.2-xml \
    php7.2-apcu \
    php7.2-intl \
    php7.2-bcmath \
    php7.2-pdo \
    php7.2-mysql \
    php7.2-tokenizer \
    php7.2-redis \
    php7.2-amqp \
    php7.2-zip \
    --no-install-recommends && rm -r /var/lib/apt/lists/*

### Configure nginx
# Copy certs
COPY ./nginx/ssl/server.crt /etc/ssl/certs/server.crt
COPY ./nginx/ssl/server.key /etc/ssl/private/server.key
# Copy configs
COPY ./nginx/nginx.conf /etc/nginx/
COPY ./nginx/messenger.conf /etc/nginx/sites-available/default
RUN mkdir -p /var/tmp/nginx

### Configure php-fpm
# Copy configs
COPY ./php/messenger.pool.conf /etc/php/7.2/fpm/pool.d/www.conf
COPY ./php/messenger.ini /etc/php/7.2/fpm/conf.d/99-override.ini
RUN mkdir -m 0775 -p /var/run/php && chown -R www-data:www-data /var/run/php

### Configure supervisord
COPY ./supervisor/supervisor.conf /etc/supervisor/supervisord.conf
COPY ./supervisor/messenger.conf /etc/supervisor/conf.d/webserver.conf

# Install composer
RUN curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer

# Prepare app
RUN mkdir -m 755 -p /var/www/messenger
RUN chown -R www-data:www-data /var/www/messenger

RUN service php7.2-fpm stop
RUN service nginx stop

WORKDIR /var/www/messenger

HEALTHCHECK --interval=30s --timeout=5s CMD curl --fail http://localhost/api/ping || exit 1

EXPOSE 80 443
CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]