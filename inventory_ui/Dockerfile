FROM php:5.4-apache
COPY . /var/www/html/
COPY ./apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY ./apache/start-apache /usr/local/bin/
RUN docker-php-ext-install pdo pdo_mysql mysql mysqli
RUN chmod +x /usr/local/bin/start-apache
RUN a2enmod rewrite
RUN chown -R www-data:www-data /var/www
CMD ["start-apache"]
