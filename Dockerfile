FROM httpd:2.4
#COPY ./public-html/ /usr/local/apache2/htdocs/
RUN bash
RUN apt update
RUN apt install apache2 libapache2-mod-fcgid -y
RUN apt install php8.2 php8.2-fpm -y
RUN update-alternatives --set php /usr/bin/php8.2
RUN apt install software-properties-common -y
#RUN add-apt-repository ppa:ondrej/php
RUN apt install libapache2-mod-php8.2 -y
RUN a2enmod php8.2
COPY phpapp.conf /etc/apache2/sites-available/000-default.conf
COPY httpd.conf /usr/local/apache2/conf/httpd.conf
COPY php8.2.conf /etc/apache2/mods-enabled/php8.2.conf
#RUN a2ensite phpapp

#RUN systemctl restart apache2
#CMD ["/usr/local/apache2/httpd", "-D"]







