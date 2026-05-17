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
            'fecha_nacimiento' => '2021-04-15',
            'sexo' => 'Macho',
            'peso' => 32.50,
            'color' => 'Dorado',
            'observaciones' => 'Paciente muy dócil, al corriente con sus vacunas anuales.',
            'dueno_nombre' => 'Carlos Mendoza',
            'dueno_telefono' => '555-8765',
            'dueno_correo' => 'carlos.mendoza@gmail.com',
            'dueno_direccion' => 'Av. Insurgentes Sur 1240, Col. del Valle',
        ]);

        Mascota::create([
            'nombre' => 'Luna',
            'especie' => 'Gato',
            'raza' => 'Siamés',
            'fecha_nacimiento' => '2022-08-20',
            'sexo' => 'Hembra',
            'peso' => 4.20,
            'color' => 'Crema con negro',
            'observaciones' => 'Se pone nerviosa durante la exploración física.',
            'dueno_nombre' => 'Ana Sofía Garza',
            'dueno_telefono' => '555-4321',
            'dueno_correo' => 'anasofia.garza@outlook.com',
            'dueno_direccion' => 'Calle Las Rosas 45, Col. Florida',
        ]);

        Mascota::create([
            'nombre' => 'Rocky',
            'especie' => 'Perro',
            'raza' => 'Bulldog Francés',
            'fecha_nacimiento' => '2020-11-10',
            'sexo' => 'Macho',
            'peso' => 12.80,
            'color' => 'Atigrado',
            'observaciones' => 'Presenta leve dificultad respiratoria por síndrome braquicefálico.',
            'dueno_nombre' => 'Roberto Fernández',
            'dueno_telefono' => '555-9876',
            'dueno_correo' => 'roberto.f@yahoo.com',
            'dueno_direccion' => 'Paseo de la Reforma 300, Col. Juárez',
        ]);

        Mascota::create([
            'nombre' => 'Bella',
            'especie' => 'Conejo',
            'raza' => 'Cabeza de León',
            'fecha_nacimiento' => '2023-01-05',
            'sexo' => 'Hembra',
            'peso' => 1.75,
            'color' => 'Blanco con gris',
            'observaciones' => 'Dieta estricta a base de heno timothy y vegetales frescos.',
            'dueno_nombre' => 'Valeria Ruiz',
            'dueno_telefono' => '555-3456',
            'dueno_correo' => 'vruiz@empresa.com',
            'dueno_direccion' => 'Calle 10 No. 204, Col. San Pedro',
        ]);
    }
}
