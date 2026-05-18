<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HorarioVeterinario extends Model
{
    protected $fillable = [
        'veterinario_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'activo',
    ];

    protected $casts = [
        'dia_semana' => 'integer',
        'activo' => 'boolean',
    ];

    public function veterinario()
    {
        return $this->belongsTo(Veterinario::class);
    }

    public function getNombreDiaAttribute()
    {
        $dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        return $dias[$this->dia_semana] ?? 'Desconocido';
    }
}
