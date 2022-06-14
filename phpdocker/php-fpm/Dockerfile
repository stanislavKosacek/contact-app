FROM phpdockerio/php:8.1-fpm
WORKDIR "/application"

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

RUN apt-get update; \
    apt-get -y --no-install-recommends install \
        git \ 
        php8.1-pgsql; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
