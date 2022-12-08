FROM php:8.1-fpm AS php-fpm

ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/

RUN chmod uga+x /usr/local/bin/install-php-extensions && sync

RUN DEBIAN_FRONTEND=noninteractive apt-get update -q \
    && DEBIAN_FRONTEND=noninteractive apt-get install -qq -y \
      curl \
      cron \
      #libldap2-dev libsasl2-dev \
      procps \
      supervisor \
      git \
      zip unzip \
      default-mysql-client \
    && install-php-extensions \
      bcmath \
      bz2 \
      calendar \
      exif \
      ffi \
      gd \
      intl \
      ldap \
      memcached \
      mysqli \
      opcache \
      pdo_mysql \
      pdo_pgsql \
      pgsql \
      redis \
      soap \
      xsl \
      zip \
      sockets \
      sysvsem \
      http \
      pcntl \
      && apt-get autoremove --purge -y && apt-get autoclean -y && apt-get clean -y

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
RUN chown -R www-data:www-data /app
