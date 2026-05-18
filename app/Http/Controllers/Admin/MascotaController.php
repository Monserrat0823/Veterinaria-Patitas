<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mascota;
use Illuminate\Http\Request;

class MascotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(\App\Datatables\MascotaTable $table)
    {
        $mascotas = $table->rows();
        $columns = $table->columns();

        return view('mascotas.index', compact('mascotas', 'columns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mascotas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'especie' => 'required|string|max:255',
            'raza' => 'nullable|string|max:255',
            'edad' => 'nullable|string|max:100',
            'sexo' => 'required|in:Macho,Hembra',
            'peso' => 'nullable|numeric|min:0',
            'color' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string',
            'dueno_nombre' => 'required|string|max:255',
            'dueno_telefono' => 'nullable|string|max:20',
            'dueno_correo' => 'nullable|email|max:255',
            'dueno_direccion' => 'nullable|string|max:255',
        ]);

        Mascota::create($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Éxito!',
            'text' => 'Mascota registrada correctamente.'
        ]);

        return redirect()->route('admin.mascotas.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mascota $mascota)
    {
        return view('mascotas.show', compact('mascota'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mascota $mascota)
    {
        return view('mascotas.edit', compact('mascota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mascota $mascota)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'especie' => 'required|string|max:255',
            'raza' => 'nullable|string|max:255',
            'edad' => 'nullable|string|max:100',
            'sexo' => 'required|in:Macho,Hembra',
            'peso' => 'nullable|numeric|min:0',
            'color' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string',
            'dueno_nombre' => 'required|string|max:255',
            'dueno_telefono' => 'nullable|string|max:20',
            'dueno_correo' => 'nullable|email|max:255',
            'dueno_direccion' => 'nullable|string|max:255',
        ]);

        $mascota->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Actualizado',
            'text' => 'Mascota actualizada correctamente.'
        ]);

        return redirect()->route('admin.mascotas.edit', $mascota);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mascota $mascota)
    {
        $mascota->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Eliminada',
            'text' => 'Mascota eliminada correctamente.'
        ]);

        return redirect()->route('admin.mascotas.index');
    }

    public function historial(Mascota $mascota)
    {
        $mascota->load('historialClinicos.veterinario', 'historialClinicos.cita');
        return view('mascotas.historial', compact('mascota'));
    }
}