<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistorialClinico extends Model
{
    use SoftDeletes;

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
        'vacuna_precio',
        'proxima_cita_estimada',
    ];

    protected $casts = [
        'fecha_consulta' => 'datetime',
        'proxima_cita_estimada' => 'date',
        'aplico_vacuna' => 'boolean',
        'vacuna_precio' => 'float',
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class)->withTrashed();
    }

    public function veterinario()
    {
        return $this->belongsTo(Veterinario::class)->withTrashed();
    }

    public function cita()
    {
        return $this->belongsTo(Cita::class)->withTrashed();
    }
}
