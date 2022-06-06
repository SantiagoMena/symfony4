FROM ubuntu:18.04
ADD . /application
ENV TZ=America/Argentina/Buenos_Aires
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN apt-get update
RUN apt-get install -y php apache2 libapache2-mod-php php-mysql php-intl git git-core curl php-curl php-xml composer zip unzip php-zip php-mbstring php-gd
# Configure Apache
RUN rm -rf /var/www/* \
    && a2enmod rewrite \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf
ADD vhost.conf /etc/apache2/sites-available/000-default.conf
ADD run.sh /run.sh
RUN chmod 0755 /run.sh
WORKDIR /application
EXPOSE 80
CMD ["/run.sh"]