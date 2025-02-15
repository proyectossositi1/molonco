# Usa la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instala la extensión intl
RUN apt-get update && \
    apt-get install -y libicu-dev && \
    docker-php-ext-install intl

# Activa mod_rewrite
RUN a2enmod rewrite

# Configura permisos y zona horaria
ENV TZ=America/Mexico_City
RUN echo "date.timezone=${TZ}" > /usr/local/etc/php/conf.d/timezone.ini

WORKDIR /var/www/html
