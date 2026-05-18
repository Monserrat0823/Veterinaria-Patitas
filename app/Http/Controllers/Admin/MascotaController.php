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
        $rules = [
            'nombre' => 'required|string|min:2|max:100',
            'especie' => 'required|string|min:2|max:100',
            'raza' => 'nullable|string|max:100',
            'edad' => 'nullable|string|max:50',
            'sexo' => 'required|in:Macho,Hembra',
            'peso' => 'nullable|numeric|min:0.1|max:500',
            'color' => 'nullable|string|max:100',
            'observaciones' => 'nullable|string|max:1000',
            'dueno_nombre' => 'required|string|min:3|max:100',
            'dueno_telefono' => 'nullable|string|min:7|max:20',
            'dueno_correo' => 'nullable|email:rfc,dns|max:150',
            'dueno_direccion' => 'nullable|string|max:255',
        ];

        $messages = [
            'nombre.required' => 'El nombre de la mascota es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos :min caracteres.',
            'especie.required' => 'La especie es obligatoria (ej. Perro, Gato).',
            'sexo.required' => 'El sexo de la mascota es obligatorio.',
            'sexo.in' => 'El sexo debe ser Macho o Hembra.',
            'peso.numeric' => 'El peso debe ser un número válido.',
            'peso.min' => 'El peso mínimo permitido es de :min kg.',
            'peso.max' => 'El peso máximo permitido es de :max kg.',
            'dueno_nombre.required' => 'El nombre del dueño es obligatorio.',
            'dueno_nombre.min' => 'El nombre del dueño debe tener al menos :min caracteres.',
            'dueno_telefono.min' => 'El teléfono debe tener al menos :min dígitos.',
            'dueno_correo.email' => 'El correo electrónico no tiene un formato válido.',
        ];

        $data = $request->validate($rules, $messages);

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
        $rules = [
            'nombre' => 'required|string|min:2|max:100',
            'especie' => 'required|string|min:2|max:100',
            'raza' => 'nullable|string|max:100',
            'edad' => 'nullable|string|max:50',
            'sexo' => 'required|in:Macho,Hembra',
            'peso' => 'nullable|numeric|min:0.1|max:500',
            'color' => 'nullable|string|max:100',
            'observaciones' => 'nullable|string|max:1000',
            'dueno_nombre' => 'required|string|min:3|max:100',
            'dueno_telefono' => 'nullable|string|min:7|max:20',
            'dueno_correo' => 'nullable|email:rfc,dns|max:150',
            'dueno_direccion' => 'nullable|string|max:255',
        ];

        $messages = [
            'nombre.required' => 'El nombre de la mascota es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos :min caracteres.',
            'especie.required' => 'La especie es obligatoria (ej. Perro, Gato).',
            'sexo.required' => 'El sexo de la mascota es obligatorio.',
            'sexo.in' => 'El sexo debe ser Macho o Hembra.',
            'peso.numeric' => 'El peso debe ser un número válido.',
            'peso.min' => 'El peso mínimo permitido es de :min kg.',
            'peso.max' => 'El peso máximo permitido es de :max kg.',
            'dueno_nombre.required' => 'El nombre del dueño es obligatorio.',
            'dueno_nombre.min' => 'El nombre del dueño debe tener al menos :min caracteres.',
            'dueno_telefono.min' => 'El teléfono debe tener al menos :min dígitos.',
            'dueno_correo.email' => 'El correo electrónico no tiene un formato válido.',
        ];

        $data = $request->validate($rules, $messages);

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