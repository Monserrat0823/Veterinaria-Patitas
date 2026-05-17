<?php

namespace Database\Seeders;

use App\Models\Veterinario;
use Illuminate\Database\Seeder;

class VeterinarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //veterinario de prueba
        Veterinario::create([
            'nombre' => 'Dr. Juan Pérez',
            'especialidad' => 'Cirugía General',
            'telefono' => '555-1234',
            'correo_electronico' => 'juan.perez@vet.com',
        ]);

    }
}
