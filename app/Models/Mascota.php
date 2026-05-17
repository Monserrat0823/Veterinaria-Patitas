<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    
    protected $fillable = [
        'nombre',
        'especie',
        'raza',
        'fecha_nacimiento',
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
        'fecha_nacimiento' => 'date',
        'peso' => 'decimal:2',
    ];
    
}
