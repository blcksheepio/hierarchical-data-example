
ARG PHP_VERSION=${PHP_VERSION}

FROM php:${PHP_VERSION}-fpm-alpine

USER root

ARG PUID=1000
ENV PUID ${PUID}

# Update APK
RUN apk update && apk upgrade 

###########################################################################
# Misc. Required Packages: General packages required for building
###########################################################################

WORKDIR ~

RUN apk update \
    && apk add --no-cache git shadow curl openssh-client icu libpng freetype libjpeg-turbo postgresql-dev libffi-dev \
    && apk add --no-cache --virtual build-dependencies icu-dev libxml2-dev freetype-dev libpng-dev libjpeg-turbo-dev g++ make autoconf \
    && docker-php-source extract && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) pdo pgsql pdo_mysql pdo_pgsql intl zip gd

###########################################################################
# xDebug:
###########################################################################

ARG INSTALL_XDEBUG=false

RUN if [ ${INSTALL_XDEBUG} = true ]; then \
    pecl install xdebug && docker-php-ext-enable xdebug \
;fi

# ADD for REMOTE debugging
COPY xdebug.ini /usr/local/etc/php/fpm/conf.d/xdebug.ini

###########################################################################
# Blackfire:
###########################################################################

USER root

ARG INSTALL_BLACKFIRE=false
ARG BLACKFIRE_CLIENT_ID
ENV BLACKFIRE_CLIENT_ID ${BLACKFIRE_CLIENT_ID}
ARG BLACKFIRE_CLIENT_TOKEN
ENV BLACKFIRE_CLIENT_TOKEN ${BLACKFIRE_CLIENT_TOKEN}

ARG INSTALL_BLACKFIRE=false

RUN if [ ${INSTALL_XDEBUG} = false -a ${INSTALL_BLACKFIRE} = true ]; then \
    version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/linux/amd64/$version \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp \
    && mv /tmp/blackfire-*.so $(php -r "echo ini_get('extension_dir');")/blackfire.so \
    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > $PHP_INI_DIR/conf.d/blackfire.ini \
;fi

# ###########################################################################
# # Set Timezone
# ###########################################################################

ARG TIMEZONE=UTC
ENV TIMEZONE ${TIMEZONE}

RUN ln -snf /usr/share/zoneinfo/$TIMEZONE /etc/localtime && echo $TIMEZONE > /etc/timezone

###########################################################################
# Final Steps:
###########################################################################

# Cleanup
USER root

RUN docker-php-source delete \
    && cd  / && rm -fr /src \
    && apk del build-dependencies \
    && rm -rf /tmp/* \
    && rm -rf /var/www/php-fpm

WORKDIR /var/www

RUN usermod -u 1000 www-data

CMD ["php-fpm"]

EXPOSE 9000