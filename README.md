# calidad
Formulario web de registro de reclamaciones/sugerencias

- entorno

 * Creacion del archivo Dockerfile:
    ```
        FROM php:7.4-apache

        COPY /src /var/www/html

        RUN docker-php-ext-install mysqli

        EXPOSE 80
    ```
* Creación del contenedor:
    ```
    docker build -t calidad-php .
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



* Crear una red Docker (no es necesario si utilizas el Docker-compose):
    -Crear la red:
    ```
    docker network create my_network
    ```
    - Conectar los dos contenedores:
    ```
    docker run -p 3000:80 -d -v C:/Users/andra/Desktop/calidad/src:/var/www/html/ --network my_network --name app-container calidad-php
    ```
    ```
    docker run --detach -p 33060:3306 --name db-container --env MYSQL_ROOT_PASSWORD=root --network my_network mysql:latest
    ```


* Crear la base de datos:
    - Acceder a la terminal del contenedor:
    ```
    docker exec -it calidad_db_1 bash
    ```
    - Entrar en el (pedirá la contraseña):
    ```
    mysql -u root -p
    ```
    - Crear la DB:
    ```
    CREATE DATABASE mi_basededatos;
    ```
    ```
    CREATE TABLE mi_basededatos.Calidad (
        id INT AUTO_INCREMENT PRIMARY KEY,
        t_incidencia ENUM('RECLAMACION', 'SUGERENCIA', 'QUEJA'),
        t_usuario ENUM('PROFESOR', 'ALUMNO'),
        categoria VARCHAR(100),
        unidad VARCHAR(100),
        descripcion VARCHAR(500),
        respuesta ENUM('Si', 'No'),
        email VARCHAR(255),
        fecha DATE,
        hora TIME
    );
    ```



DROP TABLE mi_basededatos.Calidad;
select * from mi_basededatos.Calidad;

ALTER TABLE mi_basededatos.Calidad
MODIFY respuesta ENUM('Si', 'No');
