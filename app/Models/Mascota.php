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
        'dueno_nombre',
        'dueno_telefono',
        'dueno_correo',
    ];
    
}
