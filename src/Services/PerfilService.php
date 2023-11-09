<?php
namespace Fbaconsulting\Aclpackage\Services;

use Fbaconsulting\Aclpackage\Models\Perfil;
use Fbaconsulting\Aclpackage\Models\PerfilCliente;
use Fbaconsulting\Aclpackage\Models\PerfilClientesUsuario;

class PerfilService
{
    public function obtenerPerfilesPorCliente($clienteId)
    {
        return PerfilCliente::where('cliente_id', $clienteId)
            ->where('habilitado', true)
            ->get();
    }

    public function obtenerTodosLosPerfiles()
    {
        return Perfil::all();
    }

    public function obtenerNombresPerfiles($perfilIds)
    {
        return PerfilCliente::whereIn('perfil_cliente_id', $perfilIds)
            ->pluck('nombre_personalizado', 'perfil_cliente_id')
            ->toArray();
    }

    public function obtenerPerfilesUsuarios($usuariosIds)
    {
        return PerfilClientesUsuario::whereIn('usuario_id', $usuariosIds)
            ->where('habilitado', true)
            ->get();
    }

    public function obtenerPerfilHabilitadoPorUsuario($usuarios, $perfilClientesUsuarios)
    {
        $perfilesHabilitadosPorUsuario = [];

        foreach ($usuarios as $usuarioItem) {
            $perfilHabilitado = $perfilClientesUsuarios
                ->where('usuario_id', $usuarioItem->usuario_id)
                ->where('habilitado', true)
                ->first();

            if ($perfilHabilitado) {
                $perfilesHabilitadosPorUsuario[$usuarioItem->usuario_id] = $perfilHabilitado->perfil_cliente_id;
            } else {
                $perfilesHabilitadosPorUsuario[$usuarioItem->usuario_id] = 0;
            }
        }

        return $perfilesHabilitadosPorUsuario;
    }
    public function deshabilitarPerfilesParaUsuario($usuarioId)
    {
        return PerfilClientesUsuario::where('usuario_id', $usuarioId)->update(['habilitado' => false]);
    }

    public function habilitarPerfilParaUsuario($usuarioId, $perfilId)
    {
        PerfilClientesUsuario::where('usuario_id', $usuarioId)->update(['habilitado' => false]);

        return PerfilClientesUsuario::updateOrInsert(
            ['usuario_id' => $usuarioId, 'perfil_cliente_id' => $perfilId],
            ['habilitado' => true]
        );
    }

    public function crearPerfilConRutas($nombre, $rutasSeleccionadas)
    {
        $perfil = new Perfil();
        $perfil->nombre = $nombre;
        $perfil->save();

        $perfil->rutas()->attach($rutasSeleccionadas);

        return $perfil;
    }

    public function actualizarRelacionesClientePerfil($clienteId, $perfilesSeleccionados)
    {
        $relacionesExist = PerfilCliente::where('cliente_id', $clienteId)->pluck('perfil_id')->toArray();

        foreach ($perfilesSeleccionados as $perfilId) {
            $perfil = Perfil::find($perfilId);
            $relacionExistente = PerfilCliente::where('cliente_id', $clienteId)
                ->where('perfil_id', $perfilId)
                ->first();

            $nombreParaUsar = ($relacionExistente) ? $relacionExistente->nombre_personalizado : ($perfil ? $perfil->nombre : '');

            PerfilCliente::updateOrInsert(
                ['cliente_id' => $clienteId, 'perfil_id' => $perfilId],
                ['habilitado' => true, 'nombre_personalizado' => $nombreParaUsar]
            );
        }

        $perfilesNoSeleccionados = array_diff($relacionesExist, $perfilesSeleccionados);
        if (!empty($perfilesNoSeleccionados)) {
            $relacionesDeshabilitadas = PerfilCliente::where('cliente_id', $clienteId)
                ->whereIn('perfil_id', $perfilesNoSeleccionados)
                ->get();

            foreach ($relacionesDeshabilitadas as $relacion) {
                PerfilClientesUsuario::where('perfil_cliente_id', $relacion->perfil_cliente_id)
                    ->update(['habilitado' => false]);
            }

            PerfilCliente::where('cliente_id', $clienteId)
                ->whereIn('perfil_id', $perfilesNoSeleccionados)
                ->update(['habilitado' => false]);
        }
    }

    public function actualizarNombrePersonalizado($perfilClienteId, $nombrePersonalizado)
    {
        $perfil = PerfilCliente::find($perfilClienteId);

        if (!$perfil) {
            throw new \Exception('El perfil no se encontró.');
        }

        $perfil->nombre_personalizado = $nombrePersonalizado;
        $perfil->save();

        return $perfil;
    }


}
