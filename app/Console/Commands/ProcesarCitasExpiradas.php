<?php

namespace App\Console\Commands;

use App\Models\Cita;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProcesarCitasExpiradas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'citas:procesar-expiradas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancela automáticamente las citas médicas en estado Programada cuya fecha y hora ya pasaron.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ahora = now();

        $citasExpiradas = Cita::where('estado', 'Programada')
            ->where('fecha_hora', '<', $ahora)
            ->get();

        if ($citasExpiradas->isEmpty()) {
            $this->info('No se encontraron citas expiradas para procesar.');
            return;
        }

        $count = 0;
        foreach ($citasExpiradas as $cita) {
            $observacionesActuales = $cita->observaciones ? $cita->observaciones . "\n\n" : '';
            $notaAutomatica = $observacionesActuales . "[Sistema - " . $ahora->format('d/m/Y H:i') . "]: Cancelada automáticamente por inasistencia al transcurrir la fecha y hora programada.";

            $cita->update([
                'estado' => 'Cancelada',
                'observaciones' => $notaAutomatica,
            ]);

            Log::info("Cita ID {$cita->id} (Mascota: {$cita->mascota_id}, Veterinario: {$cita->veterinario_id}) fue cancelada automáticamente por el sistema.");
            $count++;
        }

        $this->info("¡Proceso completado! Se cancelaron exitosamente {$count} citas expiradas.");
    }
}
