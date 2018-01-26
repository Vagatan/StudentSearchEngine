FROM php:7.1-apache
MAINTAINER Vagatan <grzesiek.kozak@gmail.com>

RUN apt-get update && apt-get install -y curl \
  git \
  htop \
  nano \
  unzip \
  wget \
  mysql-client

# Symfony install script
RUN mkdir -p /usr/local/bin && \
    curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony && \
    chmod a+x /usr/local/bin/symfony
# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN pear channel-discover pear.phing.info && pear upgrade --force && pear install phing/phing
# Clean up APT
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# install pdo_mysql for doctrine
RUN docker-php-ext-install pdo_mysql

RUN usermod -u 1000 www-data
RUN mkdir -p /project/web
RUN ln -s /project/web /var/www/project
RUN rm -v /etc/apache2/sites-available/000-default.conf
COPY docker/site.conf /etc/apache2/sites-available/000-default.conf

ENV TERMINFO=/opt/share/terminfo \
    TERM=xterm PHP_COMMAND=/usr/bin/php \
    DEBIAN_FRONTEND=noninteractive

WORKDIR /project
