<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Veterinario extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'especialidad',
        'telefono',
        'correo_electronico',
    ];
}
