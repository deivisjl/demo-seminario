<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    const USUARIO_ADMINISTRADOR = 'ADMINISTRADOR';

    const USUARIO_ANALISTA = 'ANALISTA';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'nombres',
        'apellidos',
        'dpi',
        'telefono',
        'direccion',
        'email',
        'email_verified_at',
        'password',
        'rol_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rol(){
        return $this->belongsTo(Rol::class);
    }

    public function esAdministrador(){

        return strtoupper($this->rol->nombre) == User::USUARIO_ADMINISTRADOR;

    }

    public function esAnalista(){

        return strtoupper($this->rol->nombre) == User::USUARIO_ANALISTA;

    }
}
