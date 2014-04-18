#Proyecto GZ

##Comandos

###Composer
Instalar dependencias del proyecto (Estando en la raiz de Symfony)
`composer install`

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