# Dockerfile para el servicio PHP-FPM
# Usamos una imagen base ligera y específica (PHP 8.3 FPM en Alpine)
FROM php:8.3-fpm-alpine

# Instalamos extensiones necesarias, priorizando la sencillez y el uso de Alpine
# para mantener la imagen pequeña.
RUN apk add --no-cache \
    mysql-client \
    # Instalamos las dependencias de la extensión pdo_mysql
    && docker-php-ext-install pdo_mysql

# Establecemos el directorio de trabajo
WORKDIR /var/www/html

# Exponemos el puerto 9000, que es el puerto por defecto de PHP-FPM
EXPOSE 9000
