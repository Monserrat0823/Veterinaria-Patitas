<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified']);

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $totalMascotas = \App\Models\Mascota::count();
        $totalVeterinarios = \App\Models\Veterinario::count();
        $citasHoy = \App\Models\Cita::whereDate('fecha_hora', \Carbon\Carbon::today())->count();
        $citasProgramadas = \App\Models\Cita::where('estado', 'Programada')->count();

        return view('dashboard', compact('totalMascotas', 'totalVeterinarios', 'citasHoy', 'citasProgramadas'));
    })->name('dashboard');

    Route::resource('roles', App\Http\Controllers\Admin\RoleController::class);
    Route::resource('mascotas', App\Http\Controllers\Admin\MascotaController::class);
    Route::get('mascotas/{mascota}/historial', [App\Http\Controllers\Admin\MascotaController::class, 'historial'])->name('mascotas.historial');
    Route::resource('veterinarios', App\Http\Controllers\Admin\VeterinarioController::class);
    Route::get('veterinarios/{veterinario}/horarios', [App\Http\Controllers\Admin\VeterinarioController::class, 'horarios'])->name('veterinarios.horarios');
    Route::post('veterinarios/{veterinario}/guardar-horarios', [App\Http\Controllers\Admin\VeterinarioController::class, 'guardarHorarios'])->name('veterinarios.guardar-horarios');
    Route::resource('citas', App\Http\Controllers\Admin\CitaController::class);
    Route::get('citas/{cita}/atender', [App\Http\Controllers\Admin\CitaController::class, 'atender'])->name('citas.atender');
    Route::post('citas/{cita}/guardar-atencion', [App\Http\Controllers\Admin\CitaController::class, 'guardarAtencion'])->name('citas.guardar-atencion');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
