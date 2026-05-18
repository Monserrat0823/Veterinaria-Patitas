<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('historial_clinicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mascota_id')->constrained('mascotas')->cascadeOnDelete();
            $table->foreignId('veterinario_id')->constrained('veterinarios')->cascadeOnDelete();
            $table->foreignId('cita_id')->nullable()->constrained('citas')->nullOnDelete();
            $table->dateTime('fecha_consulta');
            $table->string('peso')->nullable()->comment('Peso en kg');
            $table->string('temperatura')->nullable()->comment('Temperatura en °C');
            $table->string('frecuencia_cardiaca')->nullable()->comment('Frecuencia en lpm');
            $table->text('sintomas')->nullable();
            $table->text('diagnostico')->nullable();
            $table->text('tratamiento')->nullable()->comment('Receta médica');
            $table->boolean('aplico_vacuna')->default(false);
            $table->string('vacuna_nombre')->nullable();
            $table->date('proxima_cita_estimada')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_clinicos');
    }
};
