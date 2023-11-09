<?php

namespace Fbaconsulting\Aclpackage\Http\Controllers;


use Fbaconsulting\Aclpackage\Services\PerfilService;
use Fbaconsulting\Aclpackage\Services\UsuarioService;
use Illuminate\Http\Request;

class AdministracionUsuariosController extends Controller
{
    protected $perfilService;
    protected $usuarioService;

    public function __construct(PerfilService $perfilService, UsuarioService $usuarioService)
    {
        $this->perfilService = $perfilService;
        $this->usuarioService = $usuarioService;
    }


    public function index()
    {
        $usuario = auth()->user();
        $cliente = $usuario->cliente_id;

        $perfilesCliente = $this->perfilService->obtenerPerfilesPorCliente($cliente);
        $usuarios = $this->usuarioService->obtenerUsuariosPorCliente($cliente);

        $perfilClientesUsuarios = $this->perfilService->obtenerPerfilesUsuarios($usuarios->pluck('usuario_id'));
        $perfilIds = $perfilesCliente->pluck('perfil_cliente_id')->toArray();
        $perfilesNombres = $this->perfilService->obtenerNombresPerfiles($perfilIds);

        $perfilesHabilitadosPorUsuario = $this->perfilService->obtenerPerfilHabilitadoPorUsuario($usuarios, $perfilClientesUsuarios);

        return view('admin.administracion-usuarios', compact('usuarios', 'cliente', 'perfilesCliente', 'perfilesNombres', 'perfilesHabilitadosPorUsuario'));
    }

    public function update(Request $request)
    {
        try {
            $data = $request->all();

            foreach ($data as $key => $value) {
                if (strpos($key, 'perfil_') === 0) {
                    $usuarioId = substr($key, 7);

                    if ($value == "0") {
                        $this->perfilService->deshabilitarPerfilesParaUsuario($usuarioId);
                    } else {
                        $this->perfilService->habilitarPerfilParaUsuario($usuarioId, $value);
                    }
                }
            }

            return back()->with('success', 'Perfiles de usuarios actualizados con éxito.');
        } catch (\Exception $e) {
            return back()->with('error', 'Ha ocurrido un error al actualizar: ' . $e->getMessage());
        }
    }
}




