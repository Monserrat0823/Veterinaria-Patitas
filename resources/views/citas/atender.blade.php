<x-admin-layout title="Atención Médica en Consulta" :breadcrumbs="[
    [
      'name'=> 'Dashboard',
      'href' => route('admin.dashboard'),
    ],
    [
      'name'=>'Citas Médicas',
      'href' => route('admin.citas.index'),
    ],
    [
      'name'=>'Atender Paciente',
    ],
]">

<div class="max-w-6xl mx-auto" x-data="{ aplicoVacuna: false }">
    
    <!-- Encabezado Clínico -->
    <div class="bg-gradient-to-r from-teal-600 via-emerald-600 to-cyan-700 p-8 rounded-3xl text-white shadow-xl mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden">
        <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="flex items-center gap-5 z-10">
            <div class="w-16 h-16 rounded-2xl bg-white/15 backdrop-blur-md flex items-center justify-center text-3xl shadow-inner border border-white/20">
                <i class="fas fa-stethoscope"></i>
            </div>
            <div>
                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-white/20 backdrop-blur-sm uppercase tracking-wider mb-1">
                    Consulta en progreso
                </span>
                <h2 class="text-3xl font-black tracking-tight">Atención Clínica de {{ $cita->mascota->nombre }}</h2>
                <p class="text-teal-100 text-sm mt-0.5 font-medium">Doctor: {{ $cita->veterinario->nombre }} • Motivo: {{ $cita->motivo }}</p>
            </div>
        </div>
        <div class="z-10 flex gap-3">
            <a href="{{ route('admin.citas.index') }}" class="px-5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold transition-all backdrop-blur-sm border border-white/20 text-sm flex items-center gap-2">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </div>

    <!-- Ficha del Paciente -->
    <div class="bg-white p-6 rounded-3xl shadow-md border border-gray-100 mb-8 grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100/80">
            <span class="text-xs font-bold uppercase tracking-wider text-gray-400 block">Especie / Raza</span>
            <span class="text-base font-extrabold text-gray-800">{{ $cita->mascota->especie }} ({{ $cita->mascota->raza ?? 'Mestizo' }})</span>
        </div>
        <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100/80">
            <span class="text-xs font-bold uppercase tracking-wider text-gray-400 block">Edad / Sexo</span>
            <span class="text-base font-extrabold text-gray-800">{{ $cita->mascota->edad ?? 'No espec.' }} • {{ $cita->mascota->sexo }}</span>
        </div>
        <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100/80">
            <span class="text-xs font-bold uppercase tracking-wider text-gray-400 block">Dueño</span>
            <span class="text-base font-extrabold text-gray-800">{{ $cita->mascota->dueno_nombre }}</span>
        </div>
        <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100/80">
            <span class="text-xs font-bold uppercase tracking-wider text-gray-400 block">Fecha Cita</span>
            <span class="text-base font-extrabold text-indigo-600">{{ $cita->fecha_hora->format('d/m/Y H:i') }}</span>
        </div>
    </div>

    <!-- Formulario de Atención -->
    <form action="{{ route('admin.citas.guardar-atencion', $cita) }}" method="POST" class="space-y-8">
        @csrf

        <!-- Secc: Signos Vitales-->
        <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100/80 transition-all hover:shadow-xl">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center font-bold shadow-inner text-lg">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">1. Signos Vitales y Exploración</h3>
                    <p class="text-xs text-gray-500">Registre las constantes fisiológicas del paciente</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Peso (kg)</label>
                    <div class="relative">
                        <input type="text" name="peso" value="{{ old('peso', $cita->mascota->peso) }}" placeholder="Ej: 14.5" class="w-full rounded-2xl border border-gray-200 py-3 px-4.5 text-sm font-medium text-gray-800 focus:border-teal-500 focus:ring-2 focus:ring-teal-100 shadow-sm transition-all bg-gray-50/50" />
                        <span class="absolute right-4 top-3 text-sm font-bold text-gray-400">kg</span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Temperatura (°C)</label>
                    <div class="relative">
                        <input type="text" name="temperatura" value="{{ old('temperatura') }}" placeholder="Ej: 38.5" class="w-full rounded-2xl border border-gray-200 py-3 px-4.5 text-sm font-medium text-gray-800 focus:border-teal-500 focus:ring-2 focus:ring-teal-100 shadow-sm transition-all bg-gray-50/50" />
                        <span class="absolute right-4 top-3 text-sm font-bold text-gray-400">°C</span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Frecuencia Cardíaca (lpm)</label>
                    <div class="relative">
                        <input type="text" name="frecuencia_cardiaca" value="{{ old('frecuencia_cardiaca') }}" placeholder="Ej: 110" class="w-full rounded-2xl border border-gray-200 py-3 px-4.5 text-sm font-medium text-gray-800 focus:border-teal-500 focus:ring-2 focus:ring-teal-100 shadow-sm transition-all bg-gray-50/50" />
                        <span class="absolute right-4 top-3 text-sm font-bold text-gray-400">lpm</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secc 2: Diagnóstico -->
        <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100/80 transition-all hover:shadow-xl space-y-6">
            <div class="flex items-center gap-3 mb-2 pb-4 border-b border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center font-bold shadow-inner text-lg">
                    <i class="fas fa-microscope"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">2. Anamnesis y Evaluación Clínica</h3>
                    <p class="text-xs text-gray-500">Describa los hallazgos y la conclusión médica</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Síntomas / Historia Clínica actual <span class="text-red-500">*</span></label>
                <textarea name="sintomas" rows="3" placeholder="Detalle los síntomas presentados por el paciente, duración y observaciones del dueño..." class="w-full rounded-2xl border border-gray-200 py-3 px-4 text-sm font-medium text-gray-800 focus:border-teal-500 focus:ring-2 focus:ring-teal-100 shadow-sm transition-all bg-gray-50/50" required>{{ old('sintomas', $cita->motivo) }}</textarea>
                @error('sintomas') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Diagnóstico Definitivo / Presuntivo <span class="text-red-500">*</span></label>
                <textarea name="diagnostico" rows="3" placeholder="Escriba el diagnóstico determinado por la consulta..." class="w-full rounded-2xl border border-gray-200 py-3 px-4 text-sm font-medium text-gray-800 focus:border-teal-500 focus:ring-2 focus:ring-teal-100 shadow-sm transition-all bg-gray-50/50" required>{{ old('diagnostico') }}</textarea>
                @error('diagnostico') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Secc 3: Receta y Tratamiento -->
        <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100/80 transition-all hover:shadow-xl space-y-6">
            <div class="flex items-center gap-3 mb-2 pb-4 border-b border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center font-bold shadow-inner text-lg">
                    <i class="fas fa-pills"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">3. Tratamiento y Receta Médica</h3>
                    <p class="text-xs text-gray-500">Especifique los medicamentos, posología e indicaciones</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Plan de Tratamiento / Receta <span class="text-red-500">*</span></label>
                <textarea name="tratamiento" rows="4" placeholder="Ej: 1. Meloxicam 1mg: Dar 1 tableta cada 24 hrs por 5 días.&#10;2. Reposo absoluto por 72 horas..." class="w-full rounded-2xl border border-gray-200 py-3 px-4 text-sm font-medium text-gray-800 focus:border-teal-500 focus:ring-2 focus:ring-teal-100 shadow-sm transition-all bg-gray-50/50 font-mono" required>{{ old('tratamiento') }}</textarea>
                @error('tratamiento') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Vacunación -->
            <div class="pt-4 border-t border-gray-100">
                <label class="flex items-center gap-3 cursor-pointer p-4 rounded-2xl bg-emerald-50/50 border border-emerald-100 transition-all hover:bg-emerald-50">
                    <input type="checkbox" name="aplico_vacuna" value="1" x-model="aplicoVacuna" class="w-5 h-5 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500" />
                    <div>
                        <span class="font-bold text-emerald-900 block text-sm">¿Se aplicó alguna vacuna durante esta consulta?</span>
                        <span class="text-xs text-emerald-700 block">Marque esta casilla para registrar comprobante de vacunación</span>
                    </div>
                </label>

                <div x-show="aplicoVacuna" x-transition class="mt-4 p-6 rounded-2xl bg-emerald-50/80 border border-emerald-200 space-y-4">
                    <label class="block text-sm font-bold text-emerald-950 mb-1">Nombre y Lote de la Vacuna aplicada <span class="text-red-500">*</span></label>
                    <input type="text" name="vacuna_nombre" placeholder="Ej: Vacuna Quíntuple Zoetis (Lote #49281A) - Refuerzo Anual" class="w-full rounded-xl border border-emerald-300 bg-white py-2.5 px-4 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 shadow-sm" />
                </div>
            </div>

            <!-- Próxima Cita -->
            <div class="pt-4 border-t border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Próxima cita sugerida (Opcional)</label>
                    <p class="text-xs text-gray-500 mb-2">Fecha recomendada para revisión o siguiente dosis</p>
                    <input type="date" name="proxima_cita_estimada" value="{{ old('proxima_cita_estimada') }}" class="w-full rounded-xl border border-gray-200 py-2.5 px-4 text-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-100 shadow-sm bg-gray-50/50" />
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.citas.index') }}" class="px-8 py-3 rounded-2xl border border-gray-200 text-gray-700 hover:bg-gray-100 font-bold transition-colors shadow-sm text-base">
                Cancelar
            </a>
            <button type="submit" class="px-8 py-3 rounded-2xl bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white font-extrabold shadow-xl shadow-teal-500/30 transition-all text-base flex items-center gap-2">
                <i class="fas fa-check-circle"></i> Finalizar Consulta y Guardar
            </button>
        </div>

    </form>

</div>

</x-admin-layout>
