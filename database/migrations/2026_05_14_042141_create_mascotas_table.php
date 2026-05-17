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
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('especie');
            $table->string('raza')->nullable();
            $table->string('edad')->nullable();
            $table->enum('sexo', ['Macho', 'Hembra']);
            $table->decimal('peso', 5, 2)->nullable();
            $table->string('color')->nullable();
            $table->text('observaciones')->nullable();
            // Datos del dueño
            $table->string('dueno_nombre');
            $table->string('dueno_telefono')->nullable();
            $table->string('dueno_correo')->nullable();
            $table->string('dueno_direccion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};
