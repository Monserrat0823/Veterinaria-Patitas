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
        Schema::create('horario_veterinarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('veterinario_id')->constrained('veterinarios')->cascadeOnDelete();
            $table->integer('dia_semana')->comment('0: Domingo, 1: Lunes, 2: Martes, 3: Miercoles, 4: Jueves, 5: Viernes, 6: Sabado');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horario_veterinarios');
    }
};
