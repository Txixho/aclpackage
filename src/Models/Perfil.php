<?php

namespace Fbaconsulting\Aclpackage\Models;

use Fbaconsulting\Aclpackage\Models\Cliente;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfiles';
    protected $primaryKey = 'perfil_id';
    public $timestamps = false;

    protected $fillable = ['nombre', 'descripcion', 'habilitado'];

    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'perfiles_clientes', 'perfil_id', 'cliente_id')
            ->withPivot('nombre_personalizado');
    }

    public function rutas()
    {
        return $this->belongsToMany(Ruta::class, 'perfiles_rutas', 'perfil_id', 'ruta_id');
    }

    //Obtener todos los perfiles
    public static function obtenerTodosLosPerfiles()
    {
        return self::all();
    }


}

