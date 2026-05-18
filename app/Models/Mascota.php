<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    
    protected $fillable = [
        'nombre',
        'especie',
        'raza',
        'edad',
        'sexo',
        'peso',
        'color',
        'observaciones',
        'dueno_nombre',
        'dueno_telefono',
        'dueno_correo',
        'dueno_direccion',
    ];

    protected $casts = [
        'peso' => 'decimal:2',
    ];
    
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    public function historialClinicos()
    {
        return $this->hasMany(HistorialClinico::class)->orderBy('fecha_consulta', 'desc');
    }
}
