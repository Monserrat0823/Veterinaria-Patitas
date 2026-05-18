<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Veterinario extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'especialidad',
        'telefono',
        'correo_electronico',
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    public function historialClinicos()
    {
        return $this->hasMany(HistorialClinico::class);
    }

    public function horarios()
    {
        return $this->hasMany(HorarioVeterinario::class)->orderBy('dia_semana');
    }
}
