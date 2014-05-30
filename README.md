#Proyecto GZ

##Instrucciones de instalacion

1. Crear carpeta GZ en el servidor apache con `mkdir GZ`

2. inicializar un repositorio vacio dentro de la carpeta GZ -> `git init`

3. Crear un puntero al repositorio -> `git remote add origin https://github.com/Gbrlx5/GZ.git`

4. Halar los cambios existentes en github -> `git pull -u origin master`

5. Debido a las multiples depedencias de php, es necesario tener instalado composer en la maquina local
lo puedes instalar desde aqui -> http://jallander.wordpress.com/2013/09/09/instalar-composer-phar-globalmente-en-linux-mint/

6. una vez que ya tienes composer en tu sistema, tienes que ir a la ruta /servidorlocal/GZ/Symfony y ejecutar -> `composer install`

7. descargar el siguiente binario wkhtmltopdf desde el siguiente enlace `http://wkhtmltopdf.org/downloads.html` extraer el archivo `wkhtmltopdf` y guardarlo en la siguiente ruta de la maquina local `/usr/local/bin/`

8. ejecutar el siguiente comando dentro del proyecto de symfony `php app/console assets:install --symlink web`


9. luego ir a la ruta /servidorlocal/GZ/Symfony/app, crear las carpetas `cache` y `logs` y ejecutar
`chmod -R 777 cache` y `chmod -R 777 logs`

10. (base de datos - mysql) para que el sistema funcione correctamente es necesario crear una base de datos llamada `SymfonyGZ` y un usuario con todos los privilegios con el mismo nombre  `SymfonyGZ` y contrasena `symfonygz`


11. abrir el navegador e ir a la siguiente ruta `http://localhost/GZ/Symfony/web/app.php/` nota: localhost puede variar dependiendo de como tengas tu configurado tu server apache



###Symfony
Limpiar cache de produccion:
`php app/console cache:clear --env=prod --no-debug`

Limpiar cache de desarrollo:
`php app/console cache:clear --env=dev --no-debug`

###Doctrine

Crear BD especificada en app/config/parameters.yml:
`php app/console doctrine:database:create`

Crear una entidad de forma asistida:
`php app/console doctrine:generate:entity`

Generar getters, setters y algo mas en las entidades (de 3 formas):

`php app/console doctrine:generate:entities Acme/StoreBundle/Entity/Product`

`php app/console doctrine:generate:entities Acme/StoreBundle/`

`php app/console doctrine:generate:entities Acme`

Actualizar tablas en la BD:
`php app/console doctrine:schema:update --force`

##Informacion adicional

Para visualizar archivos .md en el navegador chrome visitar [Markdown Preview](https://chrome.google.com/webstore/detail/markdown-preview/jmchmkecamhbiokiopfpnfgbidieafmd)