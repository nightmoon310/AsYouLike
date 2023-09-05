################################
#                              #
#   Ubuntu - PHP 7.1 CLI+FPM   #
#                              #
################################

FROM ubuntu:focal

LABEL Vendor="sms"
LABEL Description="PHP-FPM v7.2"
LABEL Version="1.0.0"

ENV LYBERTEAM_TIME_ZONE Asia/Taipei

RUN apt update -yqq
RUN apt install -y software-properties-common
RUN add-apt-repository ppa:ondrej/php
RUN apt update -yqq

RUN apt install -yqq \
	ca-certificates \
    vim \
    git \
    gcc \
    make \
    wget \
    mc \
    curl \
    nginx \
    logrotate \
    supervisor

RUN apt install -yqq \
    php7.2-pgsql \
	php7.2-mysql \
    php7.2-opcache \
	php7.2-common \
	php7.2-mbstring \
	php7.2-mcrypt \
	php7.2-soap \
	php7.2-cli \
	php7.2-intl \
	php7.2-json \
	php7.2-xsl \
	php7.2-imap \
	php7.2-ldap \
	php7.2-curl \
	php7.2-gd  \
	php7.2-dev \
    php7.2-fpm \
    php7.2-bcmath \
    php7.2-imagick \
    php7.2-zip \
    php7.2-zmq \
    php7.2-apcu \
    pkg-config \
    && apt install -y -q --no-install-recommends \
       ssmtp

RUN apt update -yqq
RUN apt install -yqq \
	php7.2-sqlite3

## Copy our config files for php7.2 fpm and php7.2 cli
RUN mkdir /run/php
COPY image-conf/php.ini /etc/php/7.2/cli/php.ini
COPY image-conf/php-fpm.ini /etc/php/7.2/fpm/php.ini
COPY image-conf/php-fpm.conf /etc/php/7.2/fpm/php-fpm.conf
COPY image-conf/www.conf /etc/php/7.2/fpm/pool.d/www.conf
COPY image-conf/supervisord.conf /etc/supervisor/supervisord.conf
COPY image-conf/nginx.conf /etc/nginx/nginx.conf
COPY image-conf/asyoulike.conf /etc/nginx/sites-enabled/default
COPY image-conf/nginx.logrotate /etc/logrotate.d/nginx.logrotate

RUN usermod -aG www-data www-data
# Reconfigure system time
RUN dpkg-reconfigure -f noninteractive tzdata

# Add default timezone
RUN echo "date.timezone=$LYBERTEAM_TIME_ZONE" > /etc/php/7.2/cli/conf.d/timezone.ini
RUN unlink /etc/localtime
RUN ln -s /usr/share/zoneinfo/Asia/Taipei /etc/localtime

#VOLUME ["/volume/config", "/volume/data", "/volume/log"]
COPY entrypoint.sh /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]

CMD ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/supervisord.conf"]

ADD ./ /var/www/html
COPY ./.env /var/www/html/.env
RUN chmod -R 777 /var/www/html/storage
RUN chmod -R 777 /var/www/html/bootstrap/cache
RUN rm -rf /var/www/html/storage/logs/*


WORKDIR /var/www/html

EXPOSE 80 443
