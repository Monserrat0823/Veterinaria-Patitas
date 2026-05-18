<x-admin-layout title="Historial Clínico" :breadcrumbs="[
    [
      'name'=> 'Dashboard',
      'href' => route('admin.dashboard'),
    ],
    [
      'name'=>'Mascotas',
      'href' => route('admin.mascotas.index'),
    ],
    [
      'name'=>'Historial de ' . $mascota->nombre,
    ],
]">

<div class="max-w-5xl mx-auto space-y-6">
    
    <!-- Encabezado -->
    <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-200 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-3xl font-bold border border-blue-100 flex-shrink-0">
                <i class="fas fa-paw"></i>
            </div>
            <div>
                <span class="text-xs uppercase font-bold tracking-wider text-gray-400 block mb-0.5">
                    Expediente Clínico
                </span>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">{{ $mascota->nombre }}</h2>
                <p class="text-gray-600 text-sm mt-0.5 font-medium">Especie: {{ $mascota->especie }} ({{ $mascota->raza ?? 'Mestizo' }}) • Sexo: {{ $mascota->sexo }} • Edad: {{ $mascota->edad ?? 'N/E' }}</p>
            </div>
        </div>
        <div class="bg-gray-50/80 p-4 rounded-xl border border-gray-200 text-sm min-w-[240px]">
            <span class="text-xs uppercase font-bold text-gray-500 block mb-1">Contacto del Propietario</span>
            <div class="font-bold text-gray-900">{{ $mascota->dueno_nombre }}</div>
            <div class="text-gray-600 mt-0.5 text-xs"><i class="fas fa-phone-alt mr-1.5 text-blue-500"></i> {{ $mascota->dueno_telefono ?? 'Sin teléfono' }}</div>
            <div class="text-gray-600 text-xs"><i class="fas fa-envelope mr-1.5 text-blue-500"></i> {{ $mascota->dueno_correo ?? 'Sin correo' }}</div>
        </div>
    </div>

    <!-- Barra de Conteo y Regreso -->
    <div class="flex justify-between items-center bg-white px-5 py-3.5 rounded-xl shadow-xs border border-gray-200 text-sm">
        <div class="text-gray-600 font-medium">
            Total de consultas en el expediente: <strong class="text-blue-600 font-bold">{{ $mascota->historialClinicos->count() }}</strong>
        </div>
        <div>
            <a href="{{ route('admin.mascotas.index') }}" class="px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 font-semibold rounded-lg transition-colors inline-flex items-center gap-2 text-xs">
                <i class="fas fa-arrow-left"></i> Volver a Mascotas
            </a>
        </div>
    </div>

    <!-- Expedientes Clínicos -->
    @if($mascota->historialClinicos->isEmpty())
        <div class="bg-white p-12 rounded-2xl shadow-xs border border-gray-200 text-center">
            <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mx-auto text-2xl mb-3">
                <i class="fas fa-file-medical"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Sin historial médico</h3>
            <p class="text-sm text-gray-500 max-w-md mx-auto">Esta mascota aún no tiene consultas registradas en su expediente. Al atender una cita médica, los registros aparecerán aquí.</p>
        </div>
    @else
        <div class="space-y-6">
            @foreach($mascota->historialClinicos as $consulta)
                <div class="bg-white rounded-2xl shadow-xs border border-gray-200 overflow-hidden">
                    
                    <!-- Encabezado de la Consulta -->
                    <div class="bg-gray-100 px-6 py-3.5 border-b border-gray-200 flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-3 font-sans">
                            <i class="fas fa-stethoscope text-blue-600 text-lg"></i>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">Fecha: {{ $consulta->fecha_consulta->format('d/m/Y - H:i') }} hrs</h4>
                                <span class="text-xs text-gray-600 font-medium">Atendido por: Dr(a). {{ $consulta->veterinario->nombre ?? 'Veterinario' }}</span>
                            </div>
                        </div>

                        @if($consulta->aplico_vacuna)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                <i class="fas fa-syringe mr-1.5 text-emerald-600"></i> Vacunación Registrada
                            </span>
                        @endif
                    </div>

                    <!-- Contenido Clínico -->
                    <div class="p-6 space-y-6">
                        
                        <!-- Signos Vitales -->
                        <div class="grid grid-cols-3 gap-4 pb-6 border-b border-gray-100 text-center font-sans">
                            <div class="p-3 bg-gray-50 rounded-xl border border-gray-200">
                                <span class="text-xs font-semibold text-gray-500 block mb-0.5">Peso</span>
                                <span class="font-bold text-gray-900 text-base">{{ $consulta->peso ? $consulta->peso . ' kg' : '-' }}</span>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-xl border border-gray-200">
                                <span class="text-xs font-semibold text-gray-500 block mb-0.5">Temperatura</span>
                                <span class="font-bold text-gray-900 text-base">{{ $consulta->temperatura ? $consulta->temperatura . ' °C' : '-' }}</span>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-xl border border-gray-200">
                                <span class="text-xs font-semibold text-gray-500 block mb-0.5">Frec. Cardíaca</span>
                                <span class="font-bold text-gray-900 text-base">{{ $consulta->frecuencia_cardiaca ? $consulta->frecuencia_cardiaca . ' lpm' : '-' }}</span>
                            </div>
                        </div>

                        <!-- Diagnóstico -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-gray-100">
                            <div>
                                <h5 class="text-xs uppercase font-bold tracking-wider text-blue-600 mb-2 flex items-center gap-1.5">
                                    <i class="fas fa-notes-medical"></i> Síntomas y Motivo de Consulta
                                </h5>
                                <div class="text-sm text-gray-800 bg-blue-50/50 p-4 rounded-xl border border-blue-100/80 leading-relaxed font-normal">
                                    {{ $consulta->sintomas ?? 'Sin registro de síntomas' }}
                                </div>
                            </div>
                            <div>
                                <h5 class="text-xs uppercase font-bold tracking-wider text-emerald-600 mb-2 flex items-center gap-1.5">
                                    <i class="fas fa-check-square"></i> Diagnóstico Definitivo
                                </h5>
                                <div class="text-sm text-gray-800 bg-emerald-50/50 p-4 rounded-xl border border-emerald-100/80 leading-relaxed font-normal">
                                    {{ $consulta->diagnostico ?? 'Sin diagnóstico registrado' }}
                                </div>
                            </div>
                        </div>

                        <!-- Receta y Tratamiento -->
                        <div>
                            <h5 class="text-xs uppercase font-bold tracking-wider text-amber-700 mb-2 flex items-center gap-1.5">
                                <i class="fas fa-pills text-sm"></i> Receta e Indicaciones
                            </h5>
                            <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-sm text-amber-950 font-mono whitespace-pre-wrap leading-relaxed shadow-2xs">
                                {{ $consulta->tratamiento ?? 'Sin tratamiento prescrito' }}
                            </div>
                        </div>

                        <!-- Detalle Vacuna Aplicada -->
                        @if($consulta->aplico_vacuna && $consulta->vacuna_nombre)
                            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-300 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-lg shadow-xs flex-shrink-0">
                                    <i class="fas fa-shield-virus"></i>
                                </div>
                                <div>
                                    <span class="text-[11px] uppercase font-extrabold text-emerald-800 block mb-0.5">Certificado de Vacunación</span>
                                    <strong class="text-emerald-950 font-bold block text-sm">{{ $consulta->vacuna_nombre }}</strong>
                                </div>
                            </div>
                        @endif

                        <!-- Próxima Cita -->
                        @if($consulta->proxima_cita_estimada)
                            <div class="text-xs text-gray-500 font-bold pt-2 flex items-center gap-2">
                                <i class="fas fa-calendar-check text-blue-600"></i> Próxima cita recomendada: <span class="text-blue-700">{{ $consulta->proxima_cita_estimada->format('d/m/Y') }}</span>
                            </div>
                        @endif

                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>

</x-admin-layout>
