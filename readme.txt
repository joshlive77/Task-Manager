---COMANDOS DE CONSOLA

-generamos las entidades de la base de datos:

php bin/console doctrine:mapping:import App\\Entity annotation --path=src/Entity
**cambiar los nombres de las entidades a singular una vez generadas por CONSOLA

-generamos los getters y setters

php bin/console make:entity --regenerate App

-generamos un controlador para verificar que las entidades funcionan

php bin/console make:controller TaskController
php bin/console make:controller UserController

-instalamos elapache pack para que las rutas funcionen

composer require symfony/apache-pack