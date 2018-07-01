
ARG PHP_VERSION=${PHP_VERSION}

FROM php:${PHP_VERSION}-cli-alpine

USER root

ARG PUID=1000
ENV PUID ${PUID}

ARG USER_NAME=blcksheepio
ENV USER_NAME=${USER_NAME}

ARG PGID=1000
ENV PGID ${PGID}

ARG USER_GROUP_NAME=blcksheepio
ENV USER_GROUP_NAME=${USER_GROUP_NAME}

RUN addgroup -g ${PGID} ${USER_GROUP_NAME} && \
    adduser -u ${PUID} -G ${USER_GROUP_NAME} -D ${USER_NAME}

###########################################################################
# Misc. Required Packages: General packages required for building
###########################################################################

WORKDIR ~

RUN apk update \
    && apk add --no-cache git curl openssh-client icu libpng freetype libjpeg-turbo postgresql-dev libffi-dev \
    && apk add --no-cache --virtual build-dependencies icu-dev libxml2-dev freetype-dev libpng-dev libjpeg-turbo-dev g++ make autoconf \
    && docker-php-source extract && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) pdo pgsql pdo_pgsql intl zip gd bcmath

###########################################################################
# xDebug:
###########################################################################

ARG INSTALL_XDEBUG=false

RUN if [ ${INSTALL_XDEBUG} = true ]; then \
    pecl install xdebug && docker-php-ext-enable xdebug \
;fi

# ADD for REMOTE debugging
COPY xdebug.ini /usr/local/etc/php/cli/conf.d/xdebug.ini

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

# ###########################################################################
# # Composer:
# ###########################################################################

USER root

WORKDIR ~

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" &&  \
    mv ./composer.phar /usr/local/bin/composer

COPY ./composer.json /home/${USER_NAME}/.composer/composer.json

RUN chown -R ${USER_NAME}:${USER_GROUP_NAME} /home/${USER_NAME}/.composer

USER ${USER_NAME}

WORKDIR /home/${USER_NAME}

ARG COMPOSER_GLOBAL_INSTALL=true

RUN if [ ${COMPOSER_GLOBAL_INSTALL} = true ]; then \
    composer global install \
;fi

###########################################################################
# Final Steps:
###########################################################################

# Cleanup
USER root

RUN docker-php-source delete \
    && cd  / && rm -fr /src \
    && apk del build-dependencies \
    && rm -rf /tmp/*

# Final step :)
WORKDIR /var/www