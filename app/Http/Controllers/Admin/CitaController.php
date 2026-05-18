<?php

namespace App\Http\Controllers\Admin;

use App\Datatables\CitaTable;
use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\HistorialClinico;
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
        $veterinarios = Veterinario::with(['horarios', 'citas' => function($q) {
            $q->where('estado', '!=', 'Cancelada');
        }])->orderBy('nombre')->get();

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

        $fechaHora = \Carbon\Carbon::parse($data['fecha_hora']);
        $diaSemana = $fechaHora->dayOfWeek; // 0 (Domingo) a 6 (Sabado)
        $horaConsulta = $fechaHora->format('H:i:s');

        $veterinario = Veterinario::with('horarios')->find($data['veterinario_id']);
        $horarioDia = $veterinario->horarios->where('dia_semana', $diaSemana)->first();

        //dias que trabaja el veterimario
        if (!$horarioDia || !$horarioDia->activo) {
            $diasNombres = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
            return back()->withInput()->withErrors([
                'fecha_hora' => 'El Dr(a). ' . $veterinario->nombre . ' no ofrece consultas los días ' . $diasNombres[$diaSemana] . '.'
            ]);
        }

        // horario del vetrinarios
        if ($horaConsulta < $horarioDia->hora_inicio || $horaConsulta > $horarioDia->hora_fin) {
            $inicioFmt = \Carbon\Carbon::parse($horarioDia->hora_inicio)->format('H:i');
            $finFmt = \Carbon\Carbon::parse($horarioDia->hora_fin)->format('H:i');
            return back()->withInput()->withErrors([
                'fecha_hora' => 'El horario elegido (' . $fechaHora->format('H:i') . ') está fuera del turno del doctor (' . $inicioFmt . ' a ' . $finFmt . ' hrs).'
            ]);
        }
        $conflicto = Cita::where('veterinario_id', $veterinario->id)
            ->where('estado', '!=', 'Cancelada')
            ->whereBetween('fecha_hora', [
                $fechaHora->copy()->subMinutes(29),
                $fechaHora->copy()->addMinutes(29)
            ])
            ->first();

        if ($conflicto) {
            return back()->withInput()->withErrors([
                'fecha_hora' => 'El especialista ya tiene otra consulta programada a las ' . $conflicto->fecha_hora->format('H:i') . '. Por favor seleccione otro horario disponible.'
            ]);
        }

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
        $veterinarios = Veterinario::with(['horarios', 'citas' => function($q) {
            $q->where('estado', '!=', 'Cancelada');
        }])->orderBy('nombre')->get();

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

        if ($data['estado'] === 'Programada') {
            $fechaHora = \Carbon\Carbon::parse($data['fecha_hora']);
            $diaSemana = $fechaHora->dayOfWeek;
            $horaConsulta = $fechaHora->format('H:i:s');

            $veterinario = Veterinario::with('horarios')->find($data['veterinario_id']);
            $horarioDia = $veterinario->horarios->where('dia_semana', $diaSemana)->first();

            if (!$horarioDia || !$horarioDia->activo) {
                $diasNombres = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                return back()->withInput()->withErrors([
                    'fecha_hora' => 'El Dr(a). ' . $veterinario->nombre . ' no ofrece consultas los días ' . $diasNombres[$diaSemana] . '.'
                ]);
            }

            if ($horaConsulta < $horarioDia->hora_inicio || $horaConsulta > $horarioDia->hora_fin) {
                $inicioFmt = \Carbon\Carbon::parse($horarioDia->hora_inicio)->format('H:i');
                $finFmt = \Carbon\Carbon::parse($horarioDia->hora_fin)->format('H:i');
                return back()->withInput()->withErrors([
                    'fecha_hora' => 'El horario elegido (' . $fechaHora->format('H:i') . ') está fuera del turno del doctor (' . $inicioFmt . ' a ' . $finFmt . ' hrs).'
                ]);
            }

            $conflicto = Cita::where('veterinario_id', $veterinario->id)
                ->where('id', '!=', $cita->id)
                ->where('estado', '!=', 'Cancelada')
                ->whereBetween('fecha_hora', [
                    $fechaHora->copy()->subMinutes(29),
                    $fechaHora->copy()->addMinutes(29)
                ])
                ->first();

            if ($conflicto) {
                return back()->withInput()->withErrors([
                    'fecha_hora' => 'El especialista ya tiene otra consulta programada a las ' . $conflicto->fecha_hora->format('H:i') . '. Por favor seleccione otro horario disponible.'
                ]);
            }
        }

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

    public function atender(Cita $cita)
    {
        if ($cita->estado !== 'Programada') {
            session()->flash('swal', [
                'icon' => 'warning',
                'title' => 'Cita no disponible',
                'text' => 'Esta cita ya fue completada o cancelada.'
            ]);
            return redirect()->route('admin.citas.index');
        }

        $cita->load('mascota', 'veterinario');
        return view('citas.atender', compact('cita'));
    }

    public function guardarAtencion(Request $request, Cita $cita)
    {
        $data = $request->validate([
            'peso' => 'nullable|string|max:50',
            'temperatura' => 'nullable|string|max:50',
            'frecuencia_cardiaca' => 'nullable|string|max:50',
            'sintomas' => 'required|string',
            'diagnostico' => 'required|string',
            'tratamiento' => 'required|string',
            'vacuna_nombre' => 'nullable|string|max:255',
            'proxima_cita_estimada' => 'nullable|date',
        ]);

        HistorialClinico::create([
            'mascota_id' => $cita->mascota_id,
            'veterinario_id' => $cita->veterinario_id,
            'cita_id' => $cita->id,
            'fecha_consulta' => now(),
            'peso' => $data['peso'] ?? null,
            'temperatura' => $data['temperatura'] ?? null,
            'frecuencia_cardiaca' => $data['frecuencia_cardiaca'] ?? null,
            'sintomas' => $data['sintomas'],
            'diagnostico' => $data['diagnostico'],
            'tratamiento' => $data['tratamiento'],
            'aplico_vacuna' => $request->has('aplico_vacuna'),
            'vacuna_nombre' => $data['vacuna_nombre'] ?? null,
            'proxima_cita_estimada' => $data['proxima_cita_estimada'] ?? null,
        ]);

        $cita->update(['estado' => 'Completada']);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Consulta Registrada!',
            'text' => 'El historial clínico se guardó y la cita se marcó como completada.'
        ]);

        return redirect()->route('admin.citas.index');
    }
}
