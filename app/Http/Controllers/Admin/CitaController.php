<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cita;
use App\Models\Mascota;
use App\Models\Dueno;
use App\Models\Veterinario;
use App\Models\TipoMascota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index()
    {
        return view('citas.index');
    }

    public function create()
    {
        return view('citas.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        return view('admi.citas.show');
    }

    public function edit(Mascota $mascota, Cita $cita)
    {
        return view('citas.edit',compact('mascota','cita'));        
    }

public function update(Request $request, Cita $cita)
{
    $request->validate([

        'name_mascota' => 'required|string|min:2|max:255',
        'raza' => 'nullable|string|min:3|max:255',
        'dueno_id' => 'required|exists:duenos,id',
        'fecha_cita' => 'required|date',
        'motivo' => 'required|string|min:3|max:255',
        'observaciones' => 'nullable|string|max:500',
        'estado_cita' => 'required|string|min:3|max:100',
        'veterinario_id' => 'required|exists:veterinarios,id',
        'color' => 'nullable|string|min:3|max:100',
        'tipo_mascota_id' => 'required|exists:tipos_mascotas,id',

    ]);

    $cita->update($request->all());

    session()->flash('swal', [
        'icon' => 'success',
        'title' => '¡Éxito!',
        'text' => 'Cita actualizada exitosamente.',
    ]);

    return redirect()->route('citas.index');
}

    public function destroy(string $id)
    {
        //
    }
}
