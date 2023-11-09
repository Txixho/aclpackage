<?php
namespace Fbaconsulting\Aclpackage\Services;

use Fbaconsulting\Aclpackage\Models\Perfil;
use Fbaconsulting\Aclpackage\Models\PerfilRutas;
use Fbaconsulting\Aclpackage\Models\Ruta;
use Illuminate\Routing\Router;

class RutaService
{
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function obtenerTodasLasRutas()
    {
        return Ruta::all();
    }

    public function obtenerRutasHabilitadasParaPerfil(Perfil $perfil)
    {
        return PerfilRutas::where('perfil_id', $perfil->perfil_id)
            ->where('habilitado', true)
            ->pluck('ruta_id')
            ->all();
    }

    public function actualizarRutasAsociadas(Perfil $perfil, array $rutasSeleccionadas)
    {
        $rutasData = [];
        $todasLasRutas = Ruta::pluck('ruta_id')->all();

        foreach ($todasLasRutas as $rutaId) {
            $rutasData[$rutaId] = ['habilitado' => false];
        }

        foreach ($rutasSeleccionadas as $rutaId) {
            $rutasData[$rutaId] = ['habilitado' => true];
        }

        $perfil->rutas()->sync($rutasData);
    }

    public function obtenerRutasAplicacion()
    {
        return $this->router->getRoutes()->getRoutesByName();
    }

    public function obtenerRutasTabla()
    {
        return Ruta::pluck('path')->toArray();
    }

    public function almacenarRutas()
    {
        $rutas = $this->obtenerRutasAplicacion();

        foreach ($rutas as $nombre => $ruta) {
            $nombreCompleto = $ruta->action['prefix'] ? $ruta->action['prefix'] . '.' . $nombre : $nombre;
            $rutaExistente = Ruta::where('path', $nombreCompleto)->first();

            if (!$rutaExistente) {
                Ruta::create(['path' => $nombreCompleto]);
            }
        }
    }

}
