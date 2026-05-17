<?php

namespace App\Datatables;

use App\Models\Veterinario;

class VeterinarioTable
{
    public function rows()
    {
        return Veterinario::latest()->get();
    }

    public function columns()
    {
        return [
            [
                'label' => 'ID',
                'field' => 'id',
            ],
            [
                'label' => 'Nombre',
                'field' => 'nombre',
            ],
            [
                'label' => 'Especialidad',
                'field' => 'especialidad',
            ],
            [
                'label' => 'Teléfono',
                'field' => 'telefono',
            ],
            [
                'label' => 'Email',
                'field' => 'correo_electronico',
            ],
        ];
    }
}
