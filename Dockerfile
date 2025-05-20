FROM php:8.2-apache

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y libicu-dev \
    && docker-php-ext-install intl mysqli pdo pdo_mysql

# Habilitar mod_rewrite para Apache
RUN a2enmod rewrite

# Copiar archivos del proyecto
COPY src/ /var/www/html/

# Asignar permisos
RUN chown -R www-data:www-data /var/www/html

# Puerto
EXPOSE 80
