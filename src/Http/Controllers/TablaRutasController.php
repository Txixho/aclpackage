<?php

namespace Fbaconsulting\Aclpackage\Http\Controllers;

use Fbaconsulting\Aclpackage\Models\Ruta;
use Fbaconsulting\Aclpackage\Services\RutaService;


class TablaRutasController extends Controller
{
    public function __construct(RutaService $rutaService)
    {
        $this->rutaService = $rutaService;
    }

    public function index()
    {
        $rutasAplicacion = $this->rutaService->obtenerRutasAplicacion();
        $rutasTabla = $this->rutaService->obtenerRutasTabla();
        $rutasSoloAplicacion = array_diff(array_keys($rutasAplicacion), $rutasTabla);
        $rutasSoloTabla = array_diff($rutasTabla, array_keys($rutasAplicacion));

        return view('listado-rutas', [
            'rutasAplicacion' => $rutasAplicacion,
            'rutasTabla' => $rutasTabla,
            'rutasSoloAplicacion' => $rutasSoloAplicacion,
            'rutasSoloTabla' => $rutasSoloTabla,
        ]);
    }
    public function storeRutas()
    {
        try {
            $this->rutaService->almacenarRutas();
            return redirect()->back()->with('success', 'Rutas almacenadas con éxito.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ha ocurrido un error al almacenar las rutas: ' . $e->getMessage());
        }
    }

}
