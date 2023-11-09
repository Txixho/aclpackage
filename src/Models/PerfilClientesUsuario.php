<?php

namespace Fbaconsulting\Aclpackage\Models;

use Illuminate\Database\Eloquent\Model;

class PerfilClientesUsuario extends Model
{
    protected $table = 'perfiles_clientes_usuarios';
    protected $primaryKey = 'perfil_cliente_usuario_id';

    protected $fillable = ['usuario_id', 'perfil_cliente_id'];

    public $timestamps = false;


    public function perfilCliente()
    {
        return $this->belongsTo(PerfilCliente::class, 'perfil_cliente_id', 'perfil_cliente_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'usuario_id');
    }

}
