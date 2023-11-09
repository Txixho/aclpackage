<?php
namespace Fbaconsulting\Aclpackage\Services;

use Fbaconsulting\Aclpackage\Models\PerfilClientesUsuario;
use Fbaconsulting\Aclpackage\Models\Usuario;
use Fbaconsulting\Aclpackage\Models\PerfilCliente;
use Illuminate\Support\Facades\Auth;

class UsuarioService
{

    public function obtenerClientePorUsuario($usuarioId)
    {
        return Usuario::find($usuarioId)->cliente_id;
    }

    public function obtenerUsuariosPorCliente($clienteId)
    {
        return Usuario::where('cliente_id', $clienteId)->get();
    }

    public function obtenerUsuarioPorId($id)
    {
        return Usuario::findOrFail($id);
    }

    public function obtenerPerfilPersonalizado($usuarioId)
    {
        // Buscar la relación del usuario con su perfil-cliente habilitado.
        $perfilClienteUsuario = PerfilClientesUsuario::where('usuario_id', $usuarioId)
            ->where('habilitado', true)
            ->first();

        // Si no se encuentra relación habilitada, el usuario es considerado como 'invitado'.
        if (!$perfilClienteUsuario) {
            return 'invitado';
        }

        
        $perfilClienteId = $perfilClienteUsuario->perfil_cliente_id;


        $perfilCliente = PerfilCliente::find($perfilClienteId);

        if (!$perfilCliente) {
            return 'perfil no encontrado';
        }

        $nombrePersonalizado = $perfilCliente->nombre_personalizado;


        return $nombrePersonalizado;
    }

}
