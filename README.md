# Trabajo de Enfoque (Despliegue de aplicaciones web): Aplicación Web PHP + Nginx + MySQL con Docker Compose

Este proyecto es una implementación simple y limpia de una aplicación web que utiliza **PHP 8.3 (FPM)**, **Nginx** como servidor web y **MySQL 8.0** como base de datos, orquestados mediante **Docker Compose**. El objetivo es proporcionar un entorno de desarrollo local, replicable y fácil de mantener, siguiendo las mejores prácticas de Docker.

## Estructura del Proyecto

```
php-nginx-mysql-app/
├── .env                  # Variables de entorno sensibles
├── docker-compose.yml    # Definición de los servicios (orquestación)
├── Dockerfile            # Definición de la imagen del servicio PHP
├── nginx/
│   └── default.conf      # Configuración de Nginx para PHP-FPM
└── src/
    └── index.php         # Código simple PHP de la aplicación
```

## Explicación de las Buenas Prácticas Aplicadas

1.  **Separación de Servicios (Microservicios):**
    *   Se utiliza un contenedor para cada servicio principal (`app` para PHP-FPM, `nginx` para el servidor web, `db` para MySQL). Esto mejora la escalabilidad y el mantenimiento.
2.  **Uso de Imágenes Oficiales y Específicas:**
    *   Se utiliza `php:8.3-fpm-alpine` para el servicio PHP, que es una imagen oficial, ligera (basada en Alpine) y específica para la versión requerida. Todo con idea de favorecer la sencillez de ejecución.
    *   Se utiliza `nginx:stable-alpine` y `mysql:8.0`.
3.  **Gestión de Variables Sensibles (`.env`):**
    *   Las credenciales de la base de datos y el puerto de Nginx se gestionan a través del archivo `.env`. Este archivo se referencia en `docker-compose.yml` y **debe ser excluido del control de versiones (Git)** para evitar exponer secretos.
4.  **Volúmenes Persistentes:**
    *   Se define un volumen con nombre (`db_data`) para el servicio MySQL. Esto asegura que los datos de la base de datos persistan incluso si el contenedor `db` es detenido o eliminado, cumpliendo con el requisito de conservación de datos.
5.  **Comunicación entre Contenedores:**
    *   Los servicios se comunican a través de una red definida por Docker Compose (`app-network`). El servicio PHP se conecta a MySQL usando el nombre del servicio (`db`) como hostname, y Nginx se comunica con PHP-FPM usando el nombre del servicio (`app`) y el puerto 9000.

## Instrucciones de Uso Local

Para levantar esta aplicación en entorno local, seguiremos los siguientes pasos:

1.  **Nos aseguramos de tener Docker y Docker Compose (o Docker CLI) instalados.**
2.  **Nos dirigimos al directorio raíz del proyecto** (`php-nginx-mysql-app`).
3.  **Ejecutamos el siguiente comando en la terminal** (docker compose up --build -d)
    para construir la imagen de PHP y levantar todos los servicios en segundo plano.

4.  **Accedemos a la aplicación** abriendo el navegador web en la siguiente dirección:
    
    http://localhost:8080
    

5.  **Para detener y eliminar los contenedores** (manteniendo el volumen de datos de MySQL), ejecutamos (docker compose down)

6.  **Para detener y eliminar los contenedores y el volumen de datos persistentes** (lo que borrará la base de datos), ejecutamos (docker compose down -v)

## Código PHP (`src/index.php`)

El código PHP es un ejemplo simple que utiliza la extensión **PDO** para conectarse a la base de datos MySQL. Con esto logramos:
*   Se usan variables de entorno para la configuración de la conexión.
*   Realizamos un manejo básico de excepciones.
*   Crearemos una tabla simple y una inserción de prueba.
*   Y visualizamos el estado de la conexión y los datos de la base de datos, mostrando un mensaje en pantalla.
