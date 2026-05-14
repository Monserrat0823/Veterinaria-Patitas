<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mascota;
use App\Models\Dueno;
use Illuminate\Http\Request;

class MascotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mascotas = Mascota::all();

        return view('admin.mascotas.index', compact('mascotas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $duenos = Dueno::all();

        return view('admin.mascotas.create', compact('duenos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validaciones
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'especie' => 'required|string|max:255',
            'raza' => 'required|string|max:255',
            'edad' => 'required|integer|min:0',
            'sexo' => 'required|in:Macho,Hembra',
            'dueno_id' => 'required|exists:duenos,id'
        ]);

        // Crear mascota
        Mascota::create($data);

        // Mensaje
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Mascota registrada correctamente',
            'text' => 'La mascota ha sido registrada correctamente'
        ]);

        // Redirección
        return redirect(route('admin.mascotas.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Mascota $mascota)
    {
        return view('admin.mascotas.show', compact('mascota'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mascota $mascota)
    {
        $duenos = Dueno::all();

        return view('admin.mascotas.edit', compact('mascota', 'duenos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mascota $mascota)
    {
        // Validaciones
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'especie' => 'required|string|max:255',
            'raza' => 'required|string|max:255',
            'edad' => 'required|integer|min:0',
            'sexo' => 'required|in:Macho,Hembra',
            'dueno_id' => 'required|exists:duenos,id'
        ]);

        // Actualizar
        $mascota->update($data);

        // Mensaje
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Mascota actualizada',
            'text' => 'La mascota ha sido actualizada correctamente'
        ]);

        // Redirección
        return redirect(route('admin.mascotas.edit', $mascota));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mascota $mascota)
    {
        // Eliminar
        $mascota->delete();

        // Mensaje
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Mascota eliminada',
            'text' => 'La mascota ha sido eliminada correctamente'
        ]);

        // Redirección
        return redirect(route('admin.mascotas.index'));
    }
}