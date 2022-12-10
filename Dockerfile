FROM php:8.0-apache
WORKDIR /var/www/html

COPY ./www /var/www/html

RUN apt-get update && \
    apt-get install -y git curl procps zip msmtp bsd-mailx && \
    apt-get install -y magick && \
    rm -rf /var/lib/apt/lists/*

COPY .docker /_docker

RUN rm     /var/www/html/Makefile   && \
    rm     /var/www/html/Dockerfile && \
    rm -rf /var/www/html/.git       && \
    rm -rf /var/www/html/.idea      && \
    rm -rf /var/www/html/.docker

# MapVolumes for: /var/www/html/config.php
# MapVolumes for: /var/www/html/dynamic/egg
# MapVolumes for: /var/www/html/dynamic/logs

EXPOSE 80

CMD ["/_docker/run.sh"]

