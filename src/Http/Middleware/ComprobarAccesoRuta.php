<?php

namespace Fbaconsulting\Aclpackage\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Fbaconsulting\Aclpackage\Models\PerfilRutas;


class ComprobarAccesoRuta
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle($request, Closure $next)
    {
        // Obtener el nombre de la ruta actual
        $routeName = $request->route()->getName();
        $user = $request->user();

        if (!$user) {
            return redirect('login');
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
            abort(403, 'El usuario no tiene un perfil asociado.',);
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


        return $next($request);

    }

}
