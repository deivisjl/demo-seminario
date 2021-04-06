<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActividadEconomica extends Model
{
    protected $table = 'actividad_economica';

    protected $fillable = [
        'id',
        'nombre',
    ];
}
