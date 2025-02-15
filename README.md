Proyecto CodeIgniter 4 con Docker

Este README proporciona una guía completa para que cualquier miembro del equipo pueda instalar, configurar y ejecutar este proyecto de CodeIgniter 4 usando Docker (PHP 8.x y MariaDB).

🟡 Requisitos Previos

📌 1️⃣ Instalar Docker y Docker Compose

Docker: Descargar Docker Desktop

Verificar la instalación:

docker --version
docker-compose --version

📌 2️⃣ Instalar Composer (Para gestionar dependencias de PHP)

Composer: Descargar Composer

Verificar la instalación:

composer --version

🚀 Clonar el Proyecto

git clone https://github.com/usuario/repo-codeigniter4.git
cd repo-codeigniter4

🟡 Configuración Inicial

📌 1️⃣ Copiar el archivo .env

cd src
cp env .env

📌 2️⃣ Configurar el archivo .env (Opcional)

En .env, ajusta la configuración de la base de datos:

CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8000'

database.default.hostname = localhost
database.default.database = db_molonco
database.default.username = molonco_user
database.default.password = molonco_pass
database.default.DBDriver = MySQLi
database.default.port = 3306

🟡 Instalar Dependencias

cd src
composer install

Esto generará la carpeta vendor/ que fue ignorada por .gitignore.

🚀 Iniciar el Proyecto con Docker

docker-compose up -d --build

Verifica que los contenedores estén corriendo:

docker ps

🟡 Solución a Error 403 Forbidden (Permisos de Apache)

Si aparece 403 Forbidden, ejecuta dentro del contenedor:

docker exec -it ci4_app bash
chown -R www-data:www-data /var/www/html
chmod -R 775 /var/www/html

Ir a la siguiente ruta y copiar y pegar el fragmento en el archivo: "quitar \ del \*:80"

nano /etc/apache2/sites-available/000-default.conf
<VirtualHost \*:80>
DocumentRoot /var/www/html/public

    <Directory /var/www/html/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined

</VirtualHost>

exit

Reinicia Docker:

docker-compose restart

🟡 Habilitar la Extensión intl de PHP (Si aparece Class Locale not found)

Si ves el error Class "Locale" not found, edita el Dockerfile:

FROM php:8.2-apache
RUN apt-get update && apt-get install -y libicu-dev && docker-php-ext-install intl

Luego, reconstruye Docker:

docker-compose down
docker-compose build --no-cache
docker-compose up -d

✅ Probar el Proyecto

1️⃣ Abrir el Navegador: http://localhost:8000
2️⃣ Verificar php spark (opcional):

docker exec -it ci4_app bash
php spark --version
exit

🟡 Comandos Útiles

# Ingresar al contenedor

docker exec -it ci4_app bash

# Ver logs

docker logs ci4_app

# Detener contenedores

docker-compose down

# Reiniciar contenedores

docker-compose restart

✅ Conclusión
🟢 Docker ejecutando PHP 8 y MariaDB.
🟢 composer install con dependencias.
🟢 .env correctamente configurado.
🟢 Solución a errores comunes (403 Forbidden, Class Locale not found).
🟢 Proyecto accesible desde http://localhost:8000.

Si surgen problemas, ¡avísame para solucionarlos! 🚀😊
