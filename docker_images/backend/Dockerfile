FROM edersondev/php:8.0
LABEL maintainer="Ederson Ferreira <ederson.dev@gmail.com>"

ARG PHP_VERSION=8.0

RUN apt-get update && apt-get install -y \
    php${PHP_VERSION}-bcmath \
    php${PHP_VERSION}-curl \
    php${PHP_VERSION}-pgsql

# Clean
RUN apt-get clean && apt-get autoclean && apt-get autoremove -y \
&& rm -rf /var/lib/apt/lists/*
