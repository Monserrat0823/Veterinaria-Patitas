<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cita extends Model
{
    use HasFactory, SoftDeletes;

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
        return $this->belongsTo(Mascota::class)->withTrashed();
    }

    public function veterinario()
    {
        return $this->belongsTo(Veterinario::class)->withTrashed();
    }

    public function historialClinico()
    {
        return $this->hasOne(HistorialClinico::class);
    }
}
