<?php

namespace App\Datatables;

use App\Models\User;

class UserTable
{
    public function rows()
    {
        return User::with('roles')->latest()->get();
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
                'label' => 'Email',
                'field' => 'email',
            ],
            [
                'label' => 'Rol',
                'field' => 'roles',
                'format' => fn($value) => $value->pluck('name')->implode(', '),
            ],
            [
                'label' => 'Teléfono',
                'field' => 'phone',
            ],
            [
                'label' => 'Dirección',
                'field' => 'address',
            ],
        ];
    }
}
