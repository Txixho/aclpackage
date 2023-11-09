<?php

use Fbaconsulting\Aclpackage\Http\Controllers\AdministracionClientesController;
use Fbaconsulting\Aclpackage\Http\Controllers\AdministracionPerfilesController;
use Fbaconsulting\Aclpackage\Http\Controllers\AdministracionUsuariosController;
use Fbaconsulting\Aclpackage\Http\Controllers\PerfilController;
use Fbaconsulting\Aclpackage\Http\Controllers\PerfilRutaController;
use Fbaconsulting\Aclpackage\Http\Controllers\TablaRutasController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Fbaconsulting\Aclpackage\Http\Controllers\UsuariosController;


Auth::routes();



Route::middleware(['rutaUsuario'])->group(function () {

    Route::get('/{id}/edit', [UsuariosController::class, 'edit'])->name('usuarios.edit');
});

Route::middleware(['ruta'])->group(function () {


    Route::get('/admin/crear-usuario', [UsuariosController::class, 'create'])->name('usuarios.create');

    Route::get('/admin/seleccion-perfil', [PerfilController::class, 'select'])->name('seleccion-perfil');

    Route::get('/admin/perfil-rutas/{perfil}', [PerfilRutaController::class, 'index'])->name('perfil-rutas.index');

    Route::put('/admin/perfil-rutas/{perfil}', [PerfilRutaController::class, 'update'])->name('perfil-rutas.update');

    Route::get('/admin/administracion-usuarios', [AdministracionUsuariosController::class, 'index'])->name('admin.administracion-usuarios.index');

    Route::post('/admin/administracion-usuarios/update', [AdministracionUsuariosController::class, 'Update'])
        ->name('actualizar-perfiles-usuarios');

    Route::get('/listado-rutas', [TablaRutasController::class, 'index'])->name('listado-rutas');

    Route::post('/almacenar-rutas', [TablaRutasController::class, 'storeRutas'])->name('almacenar-rutas');

    Route::get('/admin/administracion-clientes',  [AdministracionClientesController::class, 'index'])->name('admin.clientes.index');

    Route::post('/admin/administracion-clientes/update', [AdministracionClientesController::class, 'update'])
        ->name('actualizar-perfiles-clientes');

    Route::get('/admin/administracion-perfiles', [AdministracionPerfilesController::class, 'index'])->name('administracion-perfiles.index');

    Route::patch('/admin/actualizar-perfil/{perfil_cliente_id}', [AdministracionPerfilesController::class, 'actualizarPerfil'])->name('actualizarPerfil');

    Route::get('/admin/crear-perfil', [PerfilController::class, 'index'])->name('crearPerfil');

    Route::post('/admin/crear-perfil', [PerfilController::class, 'store'])->name('guardarPerfil');

});

Route::middleware(['isRoot'])->group(function () {



});