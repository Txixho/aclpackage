<?php

namespace Fbaconsulting\Aclpackage\Http\Controllers;

use Fbaconsulting\Aclpackage\Models\Perfil;
use Fbaconsulting\Aclpackage\Services\RutaService;
use Illuminate\Http\Request;

class PerfilRutaController extends Controller
{

    public function __construct(RutaService $rutaService)
    {
        $this->rutaService = $rutaService;
    }

    /**
     * Muestra la vista de administración de rutas por perfil.
     *
     * @param Perfil $perfil
     * @return \Illuminate\View\View
     */

    public function index(Perfil $perfil)
    {
        $perfilRutas = $this->rutaService->obtenerRutasHabilitadasParaPerfil($perfil);
        $rutas = $this->rutaService->obtenerTodasLasRutas();

        return view('admin.perfil-rutas', compact('perfil', 'rutas', 'perfilRutas'));
    }


    /**
     * Actualiza las rutas asociadas al perfil especificado.
     *
     * @param Request $request
     * @param Perfil $perfil
     * @return \Illuminate\Http\RedirectResponse
     */


    public function update(Request $request, Perfil $perfil)
    {
        try {
            $this->rutaService->actualizarRutasAsociadas($perfil, $request->input('rutas', []));
            return redirect()->back()->with('success', 'Rutas actualizadas con éxito.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ha ocurrido un error al actualizar las rutas: ' . $e->getMessage());
        }
    }


}

