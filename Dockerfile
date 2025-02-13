# Usamos una imagen de PHP con Apache
FROM php:7.4-apache

# Instalamos extensiones necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Activamos mod_rewrite para CodeIgniter
RUN a2enmod rewrite

# Configuramos permisos
RUN chown -R www-data:www-data /var/www/html

# Definimos el directorio de trabajo
WORKDIR /var/www/html

# Copiamos el código fuente al contenedor
COPY src/ /var/www/html/

# Exponemos el puerto 80 para Apache
EXPOSE 80