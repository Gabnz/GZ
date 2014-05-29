#Proyecto GZ

##Instrucciones de instalacion

Crear carpeta `mkdir GZ` e inicializar un repositorio vacio dentro `git init`

Crear un puntero al repositorio `git remote add origin https://github.com/Gbrlx5/GZ.git`

Halar los cambios existentes en github `git pull -u origin master`

Estando en la raiz de Symfony, revisar que cumpla con los requerimientos de configuracion
`php app/check.php`

Estando en la raiz de Symfony, Asegurarse de tener instalado composer e instalar dependencias del proyecto `composer install`

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