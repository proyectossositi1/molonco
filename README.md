# Proyecto CodeIgniter 3 con Docker

Este repositorio contiene una aplicación base construida con [CodeIgniter 3](https://codeigniter.com/) y un entorno de desarrollo configurado con Docker y Docker Compose. Este documento proporciona todas las instrucciones necesarias para instalar, configurar y ejecutar el proyecto en tu entorno local.

---

## Requisitos

- [Docker Desktop](https://www.docker.com/products/docker-desktop) instalado y en ejecución.
- Docker Compose (generalmente incluido con Docker Desktop).
- Git (para clonar el repositorio).

---

## Estructura del Proyecto

- **src/**: Contiene el código fuente de CodeIgniter 3.
- **Dockerfile**: Define la imagen del contenedor para la aplicación (PHP con Apache).
- **docker-compose.yml**: Configura los servicios de la aplicación y la base de datos.
- **README.md**: Este archivo de instrucciones.

---

## Instalación y Configuración

### 1. Clonar el Repositorio

Abre la terminal y ejecuta:

```bash
git clone https://github.com/TU_USUARIO/TU_REPOSITORIO.git
cd TU_REPOSITORIO
```

### 2. Descargar CodeIgniter 3 (si la carpeta `src/` está vacía)

Si la carpeta `src/` no existe o está vacía, descarga CodeIgniter 3 ejecutando:

```bash
curl -L https://github.com/bcit-ci/CodeIgniter/archive/refs/heads/develop.zip -o codeigniter.zip
unzip codeigniter.zip
mv CodeIgniter-develop src
rm codeigniter.zip
```

---

## Configuración de CodeIgniter

### 3.1. Configurar la URL Base

Edita el archivo `src/application/config/config.php` y establece la URL base de la aplicación. Por ejemplo:

````php
$config['base_url'] = 'http://localhost:8000/';


## Configuración de Docker

### 4. Dockerfile

El archivo `Dockerfile` construye la imagen del contenedor para la aplicación, utilizando PHP 7.4 con Apache.

```dockerfile
FROM php:7.4-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN a2enmod rewrite

WORKDIR /var/www/html

COPY src/ /var/www/html/

EXPOSE 80
````

### 5. docker-compose.yml

```yaml
services:
  app:
    image: php:8.2-apache
    container_name: ci4_app
    ports:
      - "8000:80"
    volumes:
      - ./src:/var/www/html
    networks:
      - net_molonco
    depends_on:
      - db

  db:
    image: mariadb:10.5
    container_name: ci4_db
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: db_molonco
      MYSQL_USER: molonco_user
      MYSQL_PASSWORD: molonco_pass
    ports:
      - "3306:3306"
    networks:
      - net_molonco

networks:
  net_molonco:
    driver: bridge
```

---

## Ejecución

### 6. Levantar el Entorno Docker

```bash
docker-compose up -d --build
```

### 7. Acceso a la Aplicación y Base de Datos

- **Aplicación:** [http://localhost:8080](http://localhost:8000)
- **Base de Datos:**
  - Usuario: `user`
  - Contraseña: `password`
  - Base de datos: `codeigniter_db`
  - Puerto: `3306`

---

## Comandos ## Comandos \u00dátiles

```bash
docker ps
docker exec -it codeigniter3-app bash
docker-compose logs -f
docker-compose down
```

---

## Solución de Problemas

### Errores de Sesiones / Headers Already Sent

```php
<?php
ob_start();
```

### Problemas de Conexión a la Base de Datos

- Verificar que `db` esté corriendo (`docker ps`).
- Revisar credenciales en `src/application/config/database.php`.

### Permisos de Carpetas

- Verifica que `src/` tenga permisos adecuados.

---

## Contribución

1. Fork del repositorio.
2. Crea una rama:

   ```bash
   git checkout -b nueva-funcionalidad
   ```

3. Realiza cambios y haz commits.
4. Abre un Pull Request.

---
