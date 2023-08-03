FROM php:8.1.6-fpm

#RUN CFLAGS="$CFLAGS -D_GNU_SOURCE"
RUN apt-get update && apt-get upgrade -y \
    && apt-get install -y \
    g++ \
    libbz2-dev \
    mariadb-client \
    libc-client-dev \
    libcurl4-gnutls-dev \
    libedit-dev \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libkrb5-dev \
    libldap2-dev \
    libmagickwand-dev \
    libmcrypt-dev \
    libmemcached-dev \
    libpq-dev \
    libsqlite3-dev \
    libssl-dev \
    libreadline-dev \
    libxslt1-dev \
    libzip-dev \
    zip \
    memcached \
    wget nano cron \
    unzip \
    zlib1g-dev \
    jpegoptim \
    optipng \
    pngquant \
    gifsicle \
    webp \
    && docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install -j$(nproc) imap \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) intl \
    && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-install ldap \
    && docker-php-ext-install -j$(nproc) \
    bcmath \
    bz2 \
    calendar \
    exif \
    gettext \
    mysqli \
    opcache \
    pdo_mysql \
    pdo_pgsql \
    pgsql \
    soap

RUN docker-php-ext-install -j$(nproc) \
    xsl \
    #&& docker-php-ext-install sockets \
    #&& docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install zip \
    #&& pecl install xdebug && docker-php-ext-enable xdebug \
    && pecl install memcached && docker-php-ext-enable memcached \
    && pecl install mongodb && docker-php-ext-enable mongodb \
    && pecl install redis && docker-php-ext-enable redis \
    && yes '' | pecl install imagick && docker-php-ext-enable imagick \
    && docker-php-source delete \
    && apt-get remove -y g++ wget \
    && apt-get autoremove --purge -y && apt-get autoclean -y && apt-get clean -y \
    && rm -rf /var/lib/apt/lists/* \
    && rm -rf /tmp/* /var/tmp/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# cron jobs
COPY ./cron_jobs /etc/cron.d/cron_jobs
RUN chmod 0644 /etc/cron.d/cron_jobs
RUN crontab /etc/cron.d/cron_jobs
#RUN touch /var/log/cron.log
#CMD cron && tail -f /var/log/cron.log
#RUN echo '* * * * * php /var/www/html/artisan schedule:run >> /dev/null 2>&1' >> /etc/crontab

#COPY start_service.sh /usr/local/bin/start_service
#RUN chmod u+x /usr/local/bin/start_service

#CMD ["nohup", "/usr/local/bin/start_service"]

EXPOSE 9001
