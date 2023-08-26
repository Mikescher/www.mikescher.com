FROM php:8.0-apache
WORKDIR /var/www/html

COPY ./www /var/www/html

RUN apt-get update                                         && \
    apt-get install -y git curl procps zip msmtp bsd-mailx && \
    apt-get install -y imagemagick                         && \
    rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

COPY .docker /_docker

RUN chmod +Xx /_docker/run.sh     && \ 
    chmod +Xx /_docker/init.sh

# MapVolumes for: /var/www/html/config.php
# MapVolumes for: /var/www/html/dynamic/egg
# MapVolumes for: /var/www/html/dynamic/logs

EXPOSE 80

CMD ["/_docker/run.sh"]

