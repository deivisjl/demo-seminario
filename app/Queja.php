<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Queja extends Model
{
    protected $table = 'queja';

    protected $fillable = [
        'id',
        'no',
        'no_documento',
        'fecha_documento',
        'detalle',
        'pais',
        'genero',
        'telefono_contacto',
        'correo_contacto',
        'ip',
        'empresa_id',
        'direccion'
    ];
}
