<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HorarioVeterinario;
use App\Models\Veterinario;
use Illuminate\Http\Request;

class VeterinarioController extends Controller
{
    public function index(\App\Datatables\VeterinarioTable $table)
    {
        $veterinarios = $table->rows();
        $columns = $table->columns();

        return view('veterinarios.index', compact('veterinarios', 'columns'));
    }

    public function create()
    {
        return view('veterinarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|min:3|max:255',
            'especialidad' => 'required|string|min:3|max:255',
            'telefono' => 'nullable|string|max:20',
            'correo_electronico' => 'nullable|email|max:255',
        ]);

        Veterinario::create($request->all());

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Éxito!',
            'text' => 'Veterinario registrado correctamente.',
        ]);

        return redirect()->route('admin.veterinarios.index');
    }

    public function show(Veterinario $veterinario)
    {
        return view('veterinarios.show', compact('veterinario'));
    }

    public function edit(Veterinario $veterinario)
    {
        return view('veterinarios.edit', compact('veterinario'));
    }

    public function update(Request $request, Veterinario $veterinario)
    {
        $request->validate([
            'nombre' => 'required|string|min:3|max:255',
            'especialidad' => 'required|string|min:3|max:255',
            'telefono' => 'nullable|string|max:20',
            'correo_electronico' => 'nullable|email|max:255',
        ]);

        $veterinario->update($request->all());

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Actualizado',
            'text' => 'Veterinario actualizado correctamente.',
        ]);

        return redirect()->route('admin.veterinarios.index');
    }

    public function destroy(Veterinario $veterinario)
    {
        $veterinario->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Eliminado',
            'text' => 'Veterinario eliminado correctamente.',
        ]);

        return redirect()->route('admin.veterinarios.index');
    }

    public function horarios(Veterinario $veterinario)
    {
        if ($veterinario->horarios()->count() === 0) {
            $defaultHours = [
                0 => ['inicio' => '09:00', 'fin' => '14:00', 'activo' => false], // Domingo
                1 => ['inicio' => '09:00', 'fin' => '18:00', 'activo' => true],  // Lunes
                2 => ['inicio' => '09:00', 'fin' => '18:00', 'activo' => true],  // Martes
                3 => ['inicio' => '09:00', 'fin' => '18:00', 'activo' => true],  // Miercoles
                4 => ['inicio' => '09:00', 'fin' => '18:00', 'activo' => true],  // Jueves
                5 => ['inicio' => '09:00', 'fin' => '18:00', 'activo' => true],  // Viernes
                6 => ['inicio' => '09:00', 'fin' => '14:00', 'activo' => true],  // Sabado
            ];

            foreach ($defaultHours as $dia => $h) {
                HorarioVeterinario::create([
                    'veterinario_id' => $veterinario->id,
                    'dia_semana' => $dia,
                    'hora_inicio' => $h['inicio'],
                    'hora_fin' => $h['fin'],
                    'activo' => $h['activo'],
                ]);
            }
        }

        $horarios = $veterinario->horarios;
        return view('veterinarios.horarios', compact('veterinario', 'horarios'));
    }

    public function guardarHorarios(Request $request, Veterinario $veterinario)
    {
        $data = $request->input('horarios', []);

        foreach ($veterinario->horarios as $h) {
            $diaData = $data[$h->dia_semana] ?? [];
            $h->update([
                'activo' => isset($diaData['activo']),
                'hora_inicio' => $diaData['hora_inicio'] ?? $h->hora_inicio,
                'hora_fin' => $diaData['hora_fin'] ?? $h->hora_fin,
            ]);
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Horarios Guardados',
            'text' => 'El horario y disponibilidad del médico se actualizó correctamente.',
        ]);

        return redirect()->route('admin.veterinarios.index');
    }
}   