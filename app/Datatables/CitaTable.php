<?php

namespace App\Datatables;

use App\Models\Cita;

class CitaTable
{
    public function rows()
    {
        return Cita::with(['mascota', 'veterinario'])->latest('fecha_hora')->get();
    }

    public function columns()
    {
        return [
            [
                'label' => 'ID',
                'field' => 'id',
            ],
            [
                'label' => 'Mascota',
                'field' => 'mascota_id',
                'format' => function ($row) {
                    return $row->mascota ? $row->mascota->nombre . ' (' . $row->mascota->especie . ')' : 'Mascota eliminada';
                }
            ],
            [
                'label' => 'Veterinario',
                'field' => 'veterinario_id',
                'format' => function ($row) {
                    return $row->veterinario ? $row->veterinario->nombre : 'Veterinario eliminado';
                }
            ],
            [
                'label' => 'Fecha y Hora',
                'field' => 'fecha_hora',
                'format' => function ($row) {
                    return $row->fecha_hora ? $row->fecha_hora->format('d/m/Y h:i A') : '';
                }
            ],
            [
                'label' => 'Motivo',
                'field' => 'motivo',
            ],
            [
                'label' => 'Estado',
                'field' => 'estado',
            ],
        ];
    }
}
