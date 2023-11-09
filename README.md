# Users Access Control List (ACL) Package

Este paquete proporciona una manera sencilla de añadir control de acceso basado en roles a tu aplicación Laravel.

## Instalación

Para instalar el paquete, sigue estos pasos:

### Paso 1: Agregar el Repositorio de GitHub

Primero, necesitarás decirle a Composer dónde encontrar tu paquete. Agrega el repositorio a la sección `repositories` en el `composer.json` de tu proyecto Laravel:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/Txixho/aclpackage"
        }
    ]
}
```
### Paso 2: Instalar el Paquete con Composer
Ahora puedes instalar el paquete utilizando Composer. Ejecuta el siguiente comando en tu terminal:

```bash
composer require fbaconsulting/aclpackage
```
Este comando descargará e instalará el paquete en tu proyecto.

### Paso 3: Registrar Middlewares
Después de instalar el paquete, debes registrar manualmente los middleware proporcionados por el paquete. Añade las siguientes líneas al archivo `app/Http/Kernel.php` en la sección `routeMiddleware` de tu proyecto Laravel:

```
protected $routeMiddleware = [
// ... (otros middlewares)
'ruta' => \App\Http\Middleware\ComprobarAccesoRuta::class,
'rutaUsuario' => \App\Http\Middleware\ComprobarRutaUsuario::class,
];
```

### Paso 4: Asignar Middleware a las Rutas
Por último, necesitas asignar el middleware a las rutas que quieras proteger en tu aplicación Laravel. Agrega el middleware a tus rutas en los archivos de rutas como `routes/web.php`:

```
Route::get('/ruta-protegida', function () {
// ... (tu lógica para la ruta)
})->middleware('rutaUsuario');
```
Reemplaza /ruta-protegida con la ruta específica que quieres proteger.

### Uso
Una vez terminados estos pasos, las rutas a las que hayas aplicado el middleware solo serán accesibles si el perfil del usuario autenticado tiene acceso a esas rutas.