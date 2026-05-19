<?php

namespace App\Http\Controllers\Admin;

use App\Datatables\CitaTable;
use App\Http\Controllers\Controller;
use App\Mail\CitaConfirmacion;
use App\Mail\AtencionClinicaCompletada;
use App\Models\Cita;
use App\Models\HistorialClinico;
use App\Models\Mascota;
use App\Models\Veterinario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $rules = [
            'mascota_id' => 'required|integer|exists:mascotas,id',
            'veterinario_id' => 'required|integer|exists:veterinarios,id',
            'fecha_hora' => 'required|date',
            'motivo' => 'required|string|min:3|max:255',
            'estado' => 'required|in:Programada,Completada,Cancelada',
            'observaciones' => 'nullable|string|max:1000',
        ];

        $messages = [
            'mascota_id.required' => 'Debe seleccionar una mascota.',
            'mascota_id.exists' => 'La mascota seleccionada no es válida.',
            'veterinario_id.required' => 'Debe seleccionar un especialista.',
            'veterinario_id.exists' => 'El especialista seleccionado no es válido o no está disponible.',
            'fecha_hora.required' => 'La fecha y hora de la cita son obligatorias.',
            'fecha_hora.date' => 'La fecha seleccionada no tiene un formato válido.',
            'motivo.required' => 'El motivo de la cita es obligatorio.',
            'motivo.min' => 'El motivo debe tener al menos :min caracteres.',
            'estado.required' => 'El estado de la cita es obligatorio.',
            'estado.in' => 'El estado seleccionado no es válido.',
        ];

        $data = $request->validate($rules, $messages);

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

        $cita = Cita::create($data);

        // Enviar correo de confirmación al dueño de la mascota
        $this->enviarCorreoCita($cita, 'creada');

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Cita Registrada!',
            'text' => 'La cita médica se agendó y se envió un correo de confirmación.'
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
        $rules = [
            'mascota_id' => 'required|integer|exists:mascotas,id',
            'veterinario_id' => 'required|integer|exists:veterinarios,id',
            'fecha_hora' => 'required|date',
            'motivo' => 'required|string|min:3|max:255',
            'estado' => 'required|in:Programada,Completada,Cancelada',
            'observaciones' => 'nullable|string|max:1000',
        ];

        $messages = [
            'mascota_id.required' => 'Debe seleccionar una mascota.',
            'mascota_id.exists' => 'La mascota seleccionada no es válida.',
            'veterinario_id.required' => 'Debe seleccionar un especialista.',
            'veterinario_id.exists' => 'El especialista seleccionado no es válido o no está disponible.',
            'fecha_hora.required' => 'La fecha y hora de la cita son obligatorias.',
            'fecha_hora.date' => 'La fecha seleccionada no tiene un formato válido.',
            'motivo.required' => 'El motivo de la cita es obligatorio.',
            'motivo.min' => 'El motivo debe tener al menos :min caracteres.',
            'estado.required' => 'El estado de la cita es obligatorio.',
            'estado.in' => 'El estado seleccionado no es válido.',
        ];

        $data = $request->validate($rules, $messages);

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

        // Enviar correo de actualización al dueño de la mascota
        $tipo = ($data['estado'] === 'Cancelada') ? 'cancelada' : 'actualizada';
        $this->enviarCorreoCita($cita, $tipo);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Cita Actualizada!',
            'text' => 'La cita médica se actualizó y se envió un correo de notificación.'
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
        $rules = [
            'peso' => 'nullable|string|max:50',
            'temperatura' => 'nullable|string|max:50',
            'frecuencia_cardiaca' => 'nullable|string|max:50',
            'sintomas' => 'required|string|min:5|max:2000',
            'diagnostico' => 'required|string|min:5|max:2000',
            'tratamiento' => 'required|string|min:5|max:2000',
            'aplico_vacuna' => 'nullable|boolean',
            'vacuna_nombre' => 'required_if:aplico_vacuna,1|nullable|string|max:255',
            'vacuna_precio' => 'required_if:aplico_vacuna,1|nullable|numeric|min:0',
            'proxima_cita_estimada' => 'nullable|date',
        ];

        $messages = [
            'sintomas.required' => 'Debe describir los síntomas observados en el paciente.',
            'sintomas.min' => 'La descripción de los síntomas debe tener al menos :min caracteres.',
            'diagnostico.required' => 'El diagnóstico médico es obligatorio.',
            'diagnostico.min' => 'El diagnóstico debe tener al menos :min caracteres.',
            'tratamiento.required' => 'El plan de tratamiento o receta médica es obligatorio.',
            'tratamiento.min' => 'El tratamiento debe tener al menos :min caracteres.',
            'vacuna_nombre.required_if' => 'Debe ingresar el nombre de la vacuna aplicada.',
            'vacuna_precio.required_if' => 'Debe ingresar el precio cobrado por la vacuna.',
            'vacuna_precio.numeric' => 'El precio debe ser un valor numérico.',
            'proxima_cita_estimada.date' => 'La fecha estimada para la próxima consulta no tiene un formato válido.',
        ];

        $data = $request->validate($rules, $messages);

        $aplicoVacuna = $request->has('aplico_vacuna');

        $historial = HistorialClinico::create([
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
            'aplico_vacuna' => $aplicoVacuna,
            'vacuna_nombre' => $aplicoVacuna ? ($data['vacuna_nombre'] ?? null) : null,
            'vacuna_precio' => $aplicoVacuna ? ($data['vacuna_precio'] ?? null) : null,
            'proxima_cita_estimada' => $data['proxima_cita_estimada'] ?? null,
        ]);

        $cita->update(['estado' => 'Completada']);

        // Cargar relaciones para los PDFs
        $historial->load('mascota', 'veterinario');

        // Generar PDF de la receta en memoria
        $pdfReceta = Pdf::loadView('pdf.receta-medica', compact('historial'))->output();

        // Generar PDF de la vacuna si aplica
        $pdfVacuna = null;
        if ($historial->aplico_vacuna && $historial->vacuna_precio !== null) {
            $pdfVacuna = Pdf::loadView('pdf.comprobante-vacuna', compact('historial'))->output();
        }

        // Enviar por correo al dueño si tiene correo registrado
        $correo = $cita->mascota->dueno_correo ?? null;
        if ($correo) {
            try {
                Mail::to($correo)->send(new AtencionClinicaCompletada($historial, $pdfReceta, $pdfVacuna));
            } catch (\Throwable $e) {
                Log::error("Error al enviar email de atención finalizada para cita #{$cita->id}: " . $e->getMessage());
            }
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Consulta Registrada!',
            'text' => 'El historial clínico se guardó, la cita se completó y se envió la receta/comprobante en PDF por correo.'
        ]);

        return redirect()->route('admin.citas.index');
    }

    /**
     * Envía un correo de notificación al dueño de la mascota.
     */
    private function enviarCorreoCita(Cita $cita, string $tipo): void
    {
        // Cargar la mascota con su veterinario
        $cita->load('mascota', 'veterinario');

        $correo = $cita->mascota->dueno_correo ?? null;

        if (!$correo) {
            Log::warning("CitaController: No se pudo enviar correo para cita #{$cita->id} — el dueño no tiene correo registrado.");
            return;
        }

        try {
            Mail::to($correo)->send(new CitaConfirmacion($cita, $tipo));
        } catch (\Throwable $e) {
            Log::error("CitaController: Error al enviar correo para cita #{$cita->id}: " . $e->getMessage());
        }
    }
}
