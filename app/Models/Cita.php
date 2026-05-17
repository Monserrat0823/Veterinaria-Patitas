<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'mascota_id',
        'veterinario_id',
        'fecha_hora',
        'motivo',
        'estado',
        'observaciones',
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }

    public function veterinario()
    {
        return $this->belongsTo(Veterinario::class);
    }
}
