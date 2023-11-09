<?php

namespace Fbaconsulting\Aclpackage\Http\Controllers;

use Fbaconsulting\Aclpackage\Models\Usuario;
use Fbaconsulting\Aclpackage\Services\UsuarioService;

class UsuariosController extends Controller
{
    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function edit($id)
    {
        $editedUser = $this->usuarioService->obtenerUsuarioPorId($id);
        return view('edit', ['usuario' => $editedUser]);
    }

    //todo habría que adaptar create y store de users

    public function create()
    {
        return view('admin.crear-usuario');
    }

}

