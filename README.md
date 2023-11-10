# Users Access Control List (ACL) Package

Este paquete proporciona una manera sencilla de añadir control de acceso basado en roles a tu aplicación Laravel.

## Instalación

Para instalar el paquete, sigue estos pasos:

### Paso 1: Agregar el Repositorio de GitHub

Primero, necesitarás decirle a Composer dónde encontrar tu paquete. Agrega el repositorio a la sección `repositories` (si no existe agrégala) en el `composer.json` de tu proyecto Laravel:

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
'ruta' => \Fbaconsulting\Aclpackage\Http\Middleware\ComprobarAccesoRuta::class,
'rutaUsuario' => \Fbaconsulting\Aclpackage\Http\Middleware\ComprobarRutaUsuario::class,
];
```
### Paso 4: Registrar el ServiceProvider
Una vez que el paquete esté instalado, deberás registrar el ServiceProvider en tu archivo `config/app.php`. Agrega la siguiente línea en el array providers:

```
'providers' => [
    // ...
    Fbaconsulting\Aclpackage\AclPackageServiceProvider::class,
],
```
### Paso 5: Registrar el modelo Usuario
Deberás registar el modelo Uusario en tu archivo `config/auth.php`. Agrega la siguiente línea en el array users de providers:

```
'providers' => [
        'users' => [
            //...
            'model' => Fbaconsulting\Aclpackage\Models\Usuario::class,
        ],
```

### Paso 6: Asignar Middleware a las Rutas
Por último, necesitas asignar el middleware a las rutas que quieras proteger en tu aplicación Laravel. Agrega el middleware a tus rutas en los archivos de rutas como `routes/web.php`:

```
Route::get('/ruta-protegida', function () {
// ... (tu lógica para la ruta)
})->middleware('ruta');
```
Reemplaza /ruta-protegida con la ruta específica que quieres proteger.
También podrías aplicarlo a grupos de rutas:

```
Route::middleware(['ruta'])->group(function () {

    Route::get('/ruta-protegida', [MyContoller::class, 'index'])->name('index');
});
```

### Uso
Si usas el middleware con alias `ruta`, limitarás el acceso a los usuarios cuyo perfil tenga acceso a esa ruta. Si utilizas el middleware con alias `usuarioRuta` también permitirá acceso a la ruta si el usuario_id coincide con el id requerido en la ruta.