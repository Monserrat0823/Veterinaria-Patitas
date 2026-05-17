<?php

namespace App\Datatables;

use App\Models\Mascota;

class MascotaTable
{
    public function rows()
    {
        return Mascota::latest()->get();
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
                'label' => 'Especie',
                'field' => 'especie',
            ],
            [
                'label' => 'Raza',
                'field' => 'raza',
            ],
            [
                'label' => 'Sexo',
                'field' => 'sexo',
            ],
            [
                'label' => 'Dueño',
                'field' => 'dueno_nombre',
            ],
        ];
    }
}
