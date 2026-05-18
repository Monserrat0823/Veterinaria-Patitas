<x-admin-layout title="Horarios de Disponibilidad" :breadcrumbs="[
    [
      'name'=> 'Dashboard',
      'href' => route('admin.dashboard'),
    ],
    [
      'name'=>'Veterinarios',
      'href' => route('admin.veterinarios.index'),
    ],
    [
      'name'=>'Horarios: ' . $veterinario->nombre,
    ],
]">

<div class="max-w-3xl mx-auto p-8 bg-white rounded-2xl shadow-sm border border-gray-100">
    
    <!-- Encabezado -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-6 border-b border-gray-100 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Horarios de Atención</h2>
            <p class="text-sm text-gray-500 mt-0.5">Especialista: <strong class="text-blue-600">{{ $veterinario->nombre }}</strong> ({{ $veterinario->especialidad }})</p>
        </div>
        <div>
            <a href="{{ route('admin.veterinarios.index') }}" class="text-xs font-bold text-gray-600 hover:text-gray-900 border border-gray-200 py-2 px-3.5 rounded-xl hover:bg-gray-50 transition-all inline-flex items-center gap-1.5 shadow-xs">
                <i class="fas fa-arrow-left text-gray-400"></i> Volver a Veterinarios
            </a>
        </div>
    </div>

    <!-- Formulario -->
    <form action="{{ route('admin.veterinarios.guardar-horarios', $veterinario) }}" method="POST">
        @csrf

        <div class="space-y-1 mb-8">
            <div class="hidden sm:flex justify-between px-4 pb-2 text-[11px] font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                <span>Día de la semana</span>
                <span class="mr-12">Rango de horario de consultas</span>
            </div>

            @foreach($horarios as $h)
                <div class="py-3 px-4 rounded-xl transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/70"
                     x-data="{ activo: {{ $h->activo ? 'true' : 'false' }} }"
                     :class="!activo && 'opacity-50 bg-gray-50/40'">
                    
                    <!-- Checkbox y Día -->
                    <div class="flex items-center gap-3.5 min-w-[160px]">
                        <input type="checkbox" name="horarios[{{ $h->dia_semana }}][activo]" value="1" x-model="activo"
                               class="w-4.5 h-4.5 text-blue-600 rounded border-gray-300 focus:ring-blue-500 cursor-pointer transition-all shadow-xs" />
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-gray-800 tracking-wide" :class="!activo && 'text-gray-400 line-through font-normal'">
                                {{ $h->nombre_dia }}
                            </span>
                            <span class="w-1.5 h-1.5 rounded-full" :class="activo ? 'bg-emerald-500' : 'bg-gray-300'"></span>
                        </div>
                    </div>

                    <!-- Selección de Horas -->
                    <div class="flex items-center gap-3 self-end sm:self-auto">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-400 w-6 text-right">De:</span>
                            <input type="time" name="horarios[{{ $h->dia_semana }}][hora_inicio]" value="{{ \Carbon\Carbon::parse($h->hora_inicio)->format('H:i') }}" :disabled="!activo"
                                   class="border border-gray-200 bg-white rounded-lg px-3 py-1.5 text-sm font-semibold text-gray-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:bg-white disabled:bg-gray-100 disabled:text-gray-400 transition-all shadow-2xs" />
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-gray-400 w-6 text-right">a:</span>
                            <input type="time" name="horarios[{{ $h->dia_semana }}][hora_fin]" value="{{ \Carbon\Carbon::parse($h->hora_fin)->format('H:i') }}" :disabled="!activo"
                                   class="border border-gray-200 bg-white rounded-lg px-3 py-1.5 text-sm font-semibold text-gray-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:bg-white disabled:bg-gray-100 disabled:text-gray-400 transition-all shadow-2xs" />
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        <!-- Botones de Guardar -->
        <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
            <a href="{{ route('admin.veterinarios.index') }}" class="px-6 py-2.5 rounded-xl text-gray-600 hover:bg-gray-100 text-sm font-bold transition-all">
                Cancelar
            </a>
            <button type="submit" class="px-7 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md shadow-blue-500/20 transition-all flex items-center gap-2">
                <i class="fas fa-check"></i> Guardar Horarios
            </button>
        </div>

    </form>

</div>

</x-admin-layout>
