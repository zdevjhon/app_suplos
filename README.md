# SUPLOS

Prueba desarrolladores FullStack PHP-VUE

## DESPLIEGUE
#### REQUERIMIENTOS PRINCIPALES
1. PHP V.7.4 O Superior
2. mysql  Ver 15.1 Distrib 10.4.25-MariaDB

#### CONFIGURACIONES
1. Crear una baase de datos con el nombre *dbsuplos*
2. Ejecutar el escript de la base de datos que se encuentra en la carpeta *src/DB*
3. En caso no hay el archivo *composer.json* lo creamos con el mismo nombre y pegamos el siguiente codigo.
```bash
{
    "require": {
        "vlucas/phpdotenv": "^5.5",
        "phpoffice/phpspreadsheet": "^1.28"
    },
    "autoload": {
        "psr-4": {
            "App\\": "src"
        }
    },
    "config": {
        "optimize-autoloader": true
    }
}
```
en caso de que ya existe el archivo *composer.json* verificar que el contenido

4. INSTALAR COMPOSER -> ejecute 
```bash
composer intall
composer update
```
5. Crea o modifique el archivo .env con las configuraciones principales para la conexion a base de datos
```bash
HOST = http://localhost/app_suplos
TITLE = "SUPLOS APP"
APP_NAME = "SUPLOS"

# DATABASE CONEXION
DB_HOST_TEST = 127.0.0.1
DB_USERNAME_TEST = root
DB_PASSWORD_TEST =

```
puede cambiar el host de acuerdo a su servidor local
```bash
HOST = http://localhost/app_suplos
```

### ACCESO AL SISTEMA - credenciales
- Email: admin@gmail.com
- Contraseña: 123456

## License

[MIT](https://choosealicense.com/licenses/mit/)