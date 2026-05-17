<?php

namespace App\Datatables;

use Spatie\Permission\Models\Role;

class RoleTable
{
    public function rows()
    {
        return Role::latest()->get();
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
                'field' => 'name',
            ],

            [
                'label' => 'Fecha',
                'field' => 'created_at',
                'format' => fn($value) => $value->format('d/m/Y'),
            ],
            
        ];
    }
}