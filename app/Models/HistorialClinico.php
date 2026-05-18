<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialClinico extends Model
{
    protected $fillable = [
        'mascota_id',
        'veterinario_id',
        'cita_id',
        'fecha_consulta',
        'peso',
        'temperatura',
        'frecuencia_cardiaca',
        'sintomas',
        'diagnostico',
        'tratamiento',
        'aplico_vacuna',
        'vacuna_nombre',
        'proxima_cita_estimada',
    ];

    protected $casts = [
        'fecha_consulta' => 'datetime',
        'proxima_cita_estimada' => 'date',
        'aplico_vacuna' => 'boolean',
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }

    public function veterinario()
    {
        return $this->belongsTo(Veterinario::class);
    }

    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }
}
