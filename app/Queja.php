<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Queja extends Model
{
    protected $table = 'queja';

    const QUEJA_PENDIENTE = 'Pendiente';
    const QUEJA_PROCESADA = 'Procesado';

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
        'nombres',
        'apellidos',
        'ip',
        'empresa_id',
        'direccion',
        'status'
    ];

    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function actividad_economica()
    {
        return $this->belongsTo(ActividadEconomica::class);
    }
}
