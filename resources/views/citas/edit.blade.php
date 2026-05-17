<x-admin-layout title="Editar Cita Médica" :breadcrumbs="[
    [
      'name'=> 'Dashboard',
      'href' => route('admin.dashboard'),
    ],
    [
      'name'=>'Citas Médicas',
      'href' => route('admin.citas.index'),
    ],
    [
      'name'=>'Editar Cita',
    ],
]">

<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
  
  <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 text-white flex items-center gap-4">
    <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-sm flex items-center justify-center text-2xl shadow-inner border border-white/20">
      <i class="fas fa-edit"></i>
    </div>
    <div>
      <h2 class="text-2xl font-extrabold tracking-tight">Actualizar Cita Médica #{{ $cita->id }}</h2>
      <p class="text-blue-100 text-sm mt-0.5">Actualice fecha, doctor, motivo o cambie el estado de la cita</p>
    </div>
  </div>

  <form action="{{ route('admin.citas.update', $cita) }}" method="POST" class="p-8">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
      
      {{-- Selección de Mascota --}}
      <div>
        <label class="block text-sm font-bold text-gray-700 mb-1.5">
          <i class="fas fa-paw text-blue-500 mr-1.5"></i> Mascota <span class="text-red-500">*</span>
        </label>
        <select name="mascota_id" class="w-full rounded-xl border border-gray-200 py-2.5 px-4 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 shadow-sm transition-all bg-gray-50/50" required>
          <option value="" disabled>-- Seleccione un paciente --</option>
          @foreach($mascotas as $mascota)
            <option value="{{ $mascota->id }}" {{ old('mascota_id', $cita->mascota_id) == $mascota->id ? 'selected' : '' }}>
              {{ $mascota->nombre }} ({{ $mascota->especie }} - Dueño: {{ $mascota->dueno_nombre }})
            </option>
          @endforeach
        </select>
        @error('mascota_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
      </div>

      {{-- Selección de Veterinario --}}
      <div>
        <label class="block text-sm font-bold text-gray-700 mb-1.5">
          <i class="fas fa-user-md text-blue-500 mr-1.5"></i> Veterinario Asignado <span class="text-red-500">*</span>
        </label>
        <select name="veterinario_id" class="w-full rounded-xl border border-gray-200 py-2.5 px-4 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 shadow-sm transition-all bg-gray-50/50" required>
          <option value="" disabled>-- Seleccione un doctor --</option>
          @foreach($veterinarios as $vet)
            <option value="{{ $vet->id }}" {{ old('veterinario_id', $cita->veterinario_id) == $vet->id ? 'selected' : '' }}>
              {{ $vet->nombre }} ({{ $vet->especialidad }})
            </option>
          @endforeach
        </select>
        @error('veterinario_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
      </div>

      {{-- Fecha y Hora --}}
      <div>
        <label class="block text-sm font-bold text-gray-700 mb-1.5">
          <i class="fas fa-clock text-blue-500 mr-1.5"></i> Fecha y Hora de Cita <span class="text-red-500">*</span>
        </label>
        <input type="datetime-local" name="fecha_hora" value="{{ old('fecha_hora', $cita->fecha_hora ? $cita->fecha_hora->format('Y-m-d\TH:i') : '') }}" class="w-full rounded-xl border border-gray-200 py-2.5 px-4 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 shadow-sm transition-all bg-gray-50/50" required />
        @error('fecha_hora') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
      </div>

      {{-- Estado --}}
      <div>
        <label class="block text-sm font-bold text-gray-700 mb-1.5">
          <i class="fas fa-flag text-blue-500 mr-1.5"></i> Estado de la Cita <span class="text-red-500">*</span>
        </label>
        <select name="estado" class="w-full rounded-xl border border-gray-200 py-2.5 px-4 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 shadow-sm transition-all bg-gray-50/50" required>
          <option value="Programada" {{ old('estado', $cita->estado) == 'Programada' ? 'selected' : '' }}>Programada</option>
          <option value="Completada" {{ old('estado', $cita->estado) == 'Completada' ? 'selected' : '' }}>Completada</option>
          <option value="Cancelada" {{ old('estado', $cita->estado) == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
        </select>
        @error('estado') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
      </div>

      {{-- Motivo --}}
      <div class="md:col-span-2">
        <label class="block text-sm font-bold text-gray-700 mb-1.5">
          <i class="fas fa-stethoscope text-blue-500 mr-1.5"></i> Motivo de la Cita <span class="text-red-500">*</span>
        </label>
        <input type="text" name="motivo" value="{{ old('motivo', $cita->motivo) }}" placeholder="Ej: Vacunación anual, Consulta por cojera..." class="w-full rounded-xl border border-gray-200 py-2.5 px-4 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 shadow-sm transition-all bg-gray-50/50" required />
        @error('motivo') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
      </div>

      {{-- Observaciones --}}
      <div class="md:col-span-2">
        <label class="block text-sm font-bold text-gray-700 mb-1.5">
          <i class="fas fa-file-alt text-blue-500 mr-1.5"></i> Observaciones o Recomendaciones Previas
        </label>
        <textarea name="observaciones" rows="3" placeholder="Ej: Traer cartilla de vacunación..." class="w-full rounded-xl border border-gray-200 py-2.5 px-4 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 shadow-sm transition-all bg-gray-50/50">{{ old('observaciones', $cita->observaciones) }}</textarea>
        @error('observaciones') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
      </div>

    </div>

    {{-- Botones --}}
    <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
      <a href="{{ route('admin.citas.index') }}" class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-100 font-semibold transition-colors shadow-sm flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Cancelar
      </a>
      <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold shadow-lg shadow-blue-500/30 transition-all flex items-center gap-2">
        <i class="fas fa-save"></i> Guardar Cambios
      </button>
    </div>

  </form>

</div>

</x-admin-layout>
