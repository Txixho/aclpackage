<?php

namespace Fbaconsulting\Aclpackage\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public const FBA = 1;

    protected $table = 'clientes';
    protected $primaryKey = 'cliente_id';


    public function perfiles()
    {
        return $this->belongsToMany(Perfil::class, 'perfiles_clientes', 'cliente_id', 'perfil_id')
            ->withPivot('nombre_personalizado');
    }


    public function usuarios() {
        return $this->hasMany(Usuario::class, 'cliente_id');
    }

    // todo Resto de las definiciones del modelo aquí (doctores,agrupaciones,accesos,pais,centros,dominios)
}
