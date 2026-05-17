<?php

namespace App\Http\Controllers\Admin;

use App\Datatables\CitaTable;
use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Mascota;
use App\Models\Veterinario;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CitaTable $table)
    {
        $citas = $table->rows();
        $columns = $table->columns();

        return view('citas.index', compact('citas', 'columns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mascotas = Mascota::orderBy('nombre')->get();
        $veterinarios = Veterinario::orderBy('nombre')->get();

        return view('citas.create', compact('mascotas', 'veterinarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'mascota_id' => 'required|exists:mascotas,id',
            'veterinario_id' => 'required|exists:veterinarios,id',
            'fecha_hora' => 'required|date',
            'motivo' => 'required|string|max:255',
            'estado' => 'required|in:Programada,Completada,Cancelada',
            'observaciones' => 'nullable|string',
        ]);

        Cita::create($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Cita Registrada!',
            'text' => 'La cita médica se agendó correctamente.'
        ]);

        return redirect()->route('admin.citas.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cita $cita)
    {
        return view('citas.show', compact('cita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cita $cita)
    {
        $mascotas = Mascota::orderBy('nombre')->get();
        $veterinarios = Veterinario::orderBy('nombre')->get();

        return view('citas.edit', compact('cita', 'mascotas', 'veterinarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cita $cita)
    {
        $data = $request->validate([
            'mascota_id' => 'required|exists:mascotas,id',
            'veterinario_id' => 'required|exists:veterinarios,id',
            'fecha_hora' => 'required|date',
            'motivo' => 'required|string|max:255',
            'estado' => 'required|in:Programada,Completada,Cancelada',
            'observaciones' => 'nullable|string',
        ]);

        $cita->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Cita Actualizada!',
            'text' => 'La cita médica se actualizó correctamente.'
        ]);

        return redirect()->route('admin.citas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cita $cita)
    {
        $cita->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Cita Eliminada',
            'text' => 'La cita médica ha sido cancelada y eliminada.'
        ]);

        return redirect()->route('admin.citas.index');
    }
}
