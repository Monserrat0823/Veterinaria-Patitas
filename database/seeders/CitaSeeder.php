<?php

namespace Database\Seeders;

use App\Models\Cita;
use App\Models\Mascota;
use App\Models\Veterinario;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CitaSeeder extends Seeder
{
    public function run(): void
    {
        Cita::truncate();

        $mascota = Mascota::first();
        $veterinario = Veterinario::first();

        if ($mascota && $veterinario) {
            Cita::create([
                'mascota_id' => $mascota->id,
                'veterinario_id' => $veterinario->id,
                'fecha_hora' => Carbon::tomorrow()->setHour(10)->setMinute(30),
                'motivo' => 'Vacunación anual y desparasitación',
                'estado' => 'Programada',
                'observaciones' => 'Traer cartilla de vacunación anterior.',
            ]);

            Cita::create([
                'mascota_id' => $mascota->id,
                'veterinario_id' => $veterinario->id,
                'fecha_hora' => Carbon::now()->subDays(5)->setHour(16)->setMinute(0),
                'motivo' => 'Consulta general por malestar estomacal',
                'estado' => 'Completada',
                'observaciones' => 'Se recetó dieta blanda y probióticos por 3 días.',
            ]);
        }
    }
}
