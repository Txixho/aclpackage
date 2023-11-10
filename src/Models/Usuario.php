<?php

namespace Fbaconsulting\Aclpackage\Models;

use Fbaconsulting\Aclpackage\Models\Cliente;
use Fbaconsulting\Aclpackage\Models\PerfilClientesUsuario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as BaseUser;
use Illuminate\Notifications\Notifiable;

class Usuario extends BaseUser
{
    use HasFactory,Notifiable;

    protected $table      = "usuarios";
    protected $primaryKey = 'usuario_id';
    protected $fillable   = ["cliente_id", "updated_at", "usuario_id", "login", "password", "nombre", "apellidos", "email", "tipo", "envioemail", "envioemailsiempre", "idioma", "updated_pass", "updated_self_pass", "habilitado", 'usuario_updated_id', "doctor_codigo"];
    protected $hidden = ["password", 'remember_token'];

    public function perfilesClientesUsuario()
    {
        return $this->hasMany(PerfilClientesUsuario::class, 'usuario_id', 'usuario_id');
    }
    /**
     * Cliente al que pertenece el usuario
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cliente() {
        return $this->hasOne(Cliente::class, 'cliente_id', 'cliente_id');
    }

    public function perfilCliente()
    {
        return $this->hasOne(PerfilCliente::class, 'usuario_id', 'usuario_id');
    }
    function isRoot() {
        return $this->cliente_id == Cliente::FBA;
    }

    // todo Resto de las definiciones del modelo aquí

}
