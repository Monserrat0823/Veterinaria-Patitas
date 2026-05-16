<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Veterinario;
use Illuminate\Http\Request;

class VeterinarioController extends Controller
{
    public function index()
    {
        $veterinarios = Veterinario::latest()->get();

        return view('veterinarios.index', compact('veterinarios'));
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
            'email' => 'nullable|email|max:255',
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
            'email' => 'nullable|email|max:255',
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
}   