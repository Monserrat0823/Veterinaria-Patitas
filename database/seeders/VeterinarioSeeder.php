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
        //veterinarios de prueba
        Veterinario::create([
            'nombre' => 'Dr. Juan Pérez',
            'especialidad' => 'Cirugía General',
            'telefono' => '555-1234',
            'correo_electronico' => 'juan.perez@vet.com',
        ]);

        Veterinario::create([
            'nombre' => 'Dra. María Gómez',
            'especialidad' => 'Dermatología',
            'telefono' => '555-5678',
            'correo_electronico' => 'maria.gomez@vet.com',
        ]);

        Veterinario::create([
            'nombre' => 'Dr. Carlos Rodríguez',
            'especialidad' => 'Odontología',
            'telefono' => '555-9012',
            'correo_electronico' => 'carlos.rodriguez@vet.com',
        ]);
        
        Veterinario::create([
            'nombre' => 'Dra. Ana Martínez',
            'especialidad' => 'Medicina Interna',
            'telefono' => '555-3456',
            'correo_electronico' => 'ana.martinez@vet.com',
        ]);
    }
}
