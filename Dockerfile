FROM php:8.0-apache
WORKDIR /var/www/html

RUN apt-get update                                                 && \
    apt-get install -y git curl procps zip msmtp bsd-mailx sqlite3 && \
    apt-get install -y imagemagick                                 && \
    rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite
RUN docker-php-ext-install pdo pdo_mysql bcmath
 
COPY .docker /_docker

RUN chmod +Xx /_docker/run.sh     && \
    chmod +Xx /_docker/init.sh

COPY ./www             /var/www/html
COPY ./DOCKER_GIT_INFO /DOCKER_GIT_INFO

RUN chmod a+r /DOCKER_GIT_INFO

# MapVolumes for: /var/www/html/config.php       [ro]
# MapVolumes for: /var/www/html/dynamic          [rw]
# MapVolumes for: /var/www/html/data/dynamic     [rw]
# MapVolumes for: /var/www/html/data/binaries    [ro]

EXPOSE 80

ENTRYPOINT ["/_docker/run.sh"]
CMD []

