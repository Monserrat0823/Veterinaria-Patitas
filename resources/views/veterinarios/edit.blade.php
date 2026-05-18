<x-admin-layout title="Veterinarios" :breadcrumbs="[
  [
    'name'=> 'Dashboard',
    'href'=> route('admin.dashboard'),
  ],
  [
    'name'=> 'Veterinarios',
    'href'=> route('admin.veterinarios.index'),
  ],
  [
    'name'=> 'Editar',
  ]
]">  
  
  <form action="{{ route('admin.veterinarios.update', $veterinario) }}" method="POST">
    @csrf
    @method('PUT')
    <x-wire-card>

      {{-- Header decorativo --}}
      <div class="flex items-center gap-4 mb-6 pb-4 pt-4 border-b border-gray-200">
        <div class="flex items-center justify-center w-14 h-14 rounded-full bg-gradient-to-br from-blue-400 to-indigo-600 shadow-lg">
          <i class="fas fa-user-edit text-white text-2xl"></i>
        </div>
        <div>
          <h2 class="text-xl font-bold text-gray-800">Editar Veterinario</h2>
          <p class="text-sm text-gray-500">Modifique los datos del veterinario</p>
        </div>
      </div>

      <x-validation-errors />

      {{-- Sección: Información Personal --}}
      <div class="mb-8">
        <div class="flex items-center gap-2 mb-4">
          <span class="flex items-center justify-center w-7 h-7 rounded-lg bg-teal-100 text-teal-600">
            <i class="fas fa-id-card text-sm"></i>
          </span>
          <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Información Personal</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-9">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              <i class="fas fa-user text-teal-500 mr-1"></i> Nombre Completo
            </label>
            <x-wire-input name="nombre" placeholder="Ej: Dr. Juan Pérez" value="{{ old('nombre', $veterinario->nombre) }}" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              <i class="fas fa-briefcase-medical text-teal-500 mr-1"></i> Especialidad
            </label>
            <x-wire-input name="especialidad" placeholder="Ej: Cirugía General" value="{{ old('especialidad', $veterinario->especialidad) }}" />
          </div>
        </div>
      </div>

      {{-- Sección: Contacto --}}
      <div class="mb-4">
        <div class="flex items-center gap-2 mb-4">
          <span class="flex items-center justify-center w-7 h-7 rounded-lg bg-blue-100 text-blue-600">
            <i class="fas fa-address-book text-sm"></i>
          </span>
          <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Información de Contacto</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-9">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              <i class="fas fa-phone text-blue-500 mr-1"></i> Teléfono
            </label>
            <x-wire-input name="telefono" placeholder="Ej: 555-1234" value="{{ old('telefono', $veterinario->telefono) }}" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              <i class="fas fa-envelope text-blue-500 mr-1"></i> Correo Electrónico
            </label>
            <x-wire-input name="correo_electronico" type="email" placeholder="correo@ejemplo.com" value="{{ old('correo_electronico', $veterinario->correo_electronico) }}" />
          </div>
        </div>
      </div>

      <x-slot name="footer">
        <div class="flex justify-end gap-x-3">
            <x-wire-button href="{{ route('admin.veterinarios.index') }}" flat>
              <i class="fas fa-arrow-left mr-2"></i> Cancelar
            </x-wire-button>
            <x-wire-button type="submit" blue>
              <i class="fas fa-save mr-2"></i> Actualizar Veterinario
            </x-wire-button>
        </div>
      </x-slot>
    </x-wire-card>
  </form>
  
</x-admin-layout>
