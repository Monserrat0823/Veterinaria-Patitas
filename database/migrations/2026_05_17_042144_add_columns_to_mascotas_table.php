<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mascotas', function (Blueprint $table) {
            $table->string('nombre');
            $table->string('especie');
            $table->string('raza')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('sexo', ['Macho', 'Hembra']);
            $table->decimal('peso', 5, 2)->nullable();
            $table->string('color')->nullable();
            $table->text('alergias')->nullable();
            $table->text('observaciones')->nullable();
            // Datos del dueño
            $table->string('dueno_nombre');
            $table->string('dueno_telefono')->nullable();
            $table->string('dueno_correo')->nullable();
            $table->string('dueno_direccion')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('mascotas', function (Blueprint $table) {
            $table->dropColumn([
                'nombre', 'especie', 'raza', 'fecha_nacimiento', 'sexo',
                'peso', 'color', 'alergias', 'observaciones',
                'dueno_nombre', 'dueno_telefono', 'dueno_correo', 'dueno_direccion',
            ]);
        });
    }
};
