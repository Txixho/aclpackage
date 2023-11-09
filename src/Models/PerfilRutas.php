<?php

namespace Fbaconsulting\Aclpackage\Models;

use Illuminate\Database\Eloquent\Model;

class PerfilRutas extends Model
{
    protected $table = 'perfiles_rutas';
    protected $primaryKey = 'perfil_ruta_id';
    public $timestamps = false;

    protected $fillable = ['perfil_id', 'ruta_id', 'habilitado'];

    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'perfil_id');
    }

    public function ruta()
    {
        return $this->belongsTo(Ruta::class, 'ruta_id');
    }
}
