<?php

namespace Fbaconsulting\Aclpackage\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    protected $table = 'rutas';
    protected $primaryKey = 'ruta_id';
    public $timestamps = false;

    protected $fillable = ['path', 'descripcion'];

}
