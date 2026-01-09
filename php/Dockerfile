# Se usa la versión por defecto estable y soportada (8.4)
ARG PHP_VERSION=8.4 
FROM php:${PHP_VERSION}-fpm-alpine

# Usamos la versión alpine de Linux por ligereza y seguridad
# Establecemos el directorio de trabajo
WORKDIR /var/www/html

# Instalamos las extensiones de PHP necesarias: pdo, pdo_mysql y mysqli
RUN docker-php-ext-install pdo pdo_mysql mysqli