<?php

namespace Fbaconsulting\Aclpackage\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Fbaconsulting\Aclpackage\Models\Usuario;
use Fbaconsulting\Aclpackage\Models\PerfilRutas;

class ComprobarRutaUsuario
{
    public function handle($request, Closure $next)
    {
        // Obtener el nombre de la ruta actual
        $routeName = $request->route()->getName();
        $user = $request->user();
        $routeUserId = intval($request->route('id'));


        if (!$user) {
            return redirect('login');
        }


        // Verificar si el usuario_id del usuario autenticado coincide con el id de la ruta
        if ($user->usuario_id === $routeUserId) {
            return $next($request); // El usuario tiene acceso si es el mismo usuario_id
        }

        // Obtener el perfil asociado al usuario donde habilitado sea igual a 1
        $perfilClienteUsuario = $user->perfilesClientesUsuario->first(function ($perfil) {
            return $perfil->habilitado === 1;
        });

        if (!$perfilClienteUsuario) {
            abort(403);
        }

        // Obtener el perfil_cliente_id desde el objeto PerfilClientesUsuario
        $perfilClienteId = $perfilClienteUsuario->perfil_cliente_id;

        if (!$perfilClienteId) {
            abort(403, 'El usuario no tiene un perfil asociado.');
        }

        // Obtener las rutas asociadas a ese perfil a través de la tabla perfiles_rutas
        $rutasAsociadas = PerfilRutas::where('perfil_id', $perfilClienteId)
            ->where('habilitado', 1)
            ->get();

        // Verificar si la ruta actual está en las rutas asociadas al perfil
        if (!$rutasAsociadas->isEmpty()) {
            $rutaActualExiste = $rutasAsociadas->contains(function ($perfilRuta) use ($routeName) {
                return $perfilRuta->ruta->path === $routeName;
            });

            if (!$rutaActualExiste) {
                abort(403, 'No tienes acceso a esta página.');
            }
        } else {
            abort(403, 'No hay rutas asociadas al perfil.');
        }

        abort(403, 'No tienes acceso a esta página.');
    }
}


