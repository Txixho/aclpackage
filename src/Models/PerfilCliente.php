<?php

namespace Fbaconsulting\Aclpackage\Models;

use Illuminate\Database\Eloquent\Model;

class PerfilCliente extends Model
{
    protected $table = 'perfiles_clientes';
    protected $primaryKey = 'perfil_cliente_id';
    public $timestamps = false;

    protected $fillable = ['cliente_id','perfil_id','nombre_personalizado'];

    public function perfilesClientesUsuario()
    {
        return $this->hasMany(PerfilClientesUsuario::class, 'perfil_cliente_id', 'perfil_cliente_id');
    }
    public function perfil()
    {
        return $this->belongsTo(Perfil::class);
    }
}

