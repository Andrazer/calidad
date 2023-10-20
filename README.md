# calidad
Formulario web de registro de reclamaciones/sugerencias

- entorno

 * Creacion del archivo Dockerfile:
    ```
        FROM php:7.4-apache

        COPY /src /var/www/html

        EXPOSE 80
    ```
* Creación del contenedor:
    ```
    docker build -t calidad-php .
    ```
* Recontruir un contenedor ya creado:
    ```

    ```
* Puesta en marcha del servidor web:
    ```
    docker run -p 3000:80 -d calidad-php
    ```
    Para poder realizar cambios vamos a añadir:
        ```
        pwd[nos devuelve la ruta absoluta donde estamos trabajando], añadimos /src : /var/www/html [carpeta de destino]
        docker run -p 5000:80 -d -v $(pwd)/src:/var/www/html/ calidad-php
        [docker run -p 3000:80 -d -v C:/Users/andra/Desktop/calidad/src:/var/www/html/ calidad-php] <- mia
        ```

- Descargar la imagen de mysql

    ```bash
    docker pull mysql:latest
    ```

- Crear un contenedor mysql

    ```bash
    docker run --detach -p 33060:3306 --name some-mysql-db --env MYSQL_ROOT_PASSWORD=root  mysql:latest
    ```
- Conéctese a mysql

    ```bash
    docker exec -it some-mysql-db mysql -p
    [nos pedirá la contraseña]
    ```

