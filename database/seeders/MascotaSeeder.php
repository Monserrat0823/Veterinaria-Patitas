<?php

namespace Database\Seeders;

use App\Models\Mascota;
use Illuminate\Database\Seeder;

class MascotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mascota::truncate();

        Mascota::create([
            'nombre' => 'Max',
            'especie' => 'Perro',
            'raza' => 'Golden Retriever',
            'edad' => '3 años',
            'sexo' => 'Macho',
            'peso' => 32.50,
            'color' => 'Dorado',
            'observaciones' => 'Paciente muy dócil, al corriente con sus vacunas anuales.',
            'dueno_nombre' => 'Carlos Mendoza',
            'dueno_telefono' => '555-8765',
            'dueno_correo' => 'carlos.mendoza@gmail.com',
            'dueno_direccion' => 'Av. Insurgentes Sur 1240, Col. del Valle',
        ]);
    }
}
