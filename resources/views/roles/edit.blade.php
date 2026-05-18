<x-admin-layout title="Editar Rol" :breadcrumbs="[
  [
    'name'=> 'Dashboard',
    'href'=> route('admin.dashboard'),
  ],
  [
    'name'=> 'Roles y Permisos',
    'href'=> route('admin.roles.index'),
  ],
  [
    'name'=> 'Editar Rol',
  ]
]">  
  
<div class="max-w-3xl mx-auto font-sans">
  
  <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-200 mb-6 flex items-center justify-between gap-4">
    <div class="flex items-center gap-4">
      <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-bold border border-blue-100 flex-shrink-0">
        <i class="fas fa-edit"></i>
      </div>
      <div>
        <h2 class="text-xl font-bold text-gray-900 tracking-tight">Editar Rol #{{ $role->id }}</h2>
        <p class="text-xs text-gray-500 mt-0.5">Modifique el nombre y los identificadores de este perfil del sistema</p>
      </div>
    </div>
    <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 text-xs font-semibold border border-gray-200 rounded-lg transition-colors flex items-center gap-2">
      <i class="fas fa-arrow-left"></i> Volver al listado
    </a>
  </div>

  <div class="bg-white p-8 rounded-2xl shadow-xs border border-gray-200">
    <form action="{{ route('admin.roles.update', $role) }}" method="POST" class="space-y-6">
      @csrf
      @method('PUT')

      <div>
        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">
          <i class="fas fa-id-badge text-blue-500 mr-1.5"></i> Nombre del Rol <span class="text-red-500">*</span>
        </label>
        <input type="text" id="name" name="name" placeholder="Nombre del rol" value="{{ old('name', $role->name) }}" 
               class="w-full rounded-xl border border-gray-300 py-2.5 px-4 text-sm font-medium text-gray-900 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-xs bg-white" required>
        @error('name')
            <p class="mt-1.5 text-xs font-semibold text-red-600"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
        @enderror
      </div>

      <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
        <a href="{{ route('admin.roles.index') }}" class="px-5 py-2.5 bg-gray-50 hover:bg-gray-100 text-gray-700 font-bold text-xs rounded-xl border border-gray-200 transition-colors">
          Cancelar
        </a>
        <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-md transition-all flex items-center gap-2 cursor-pointer">
          <i class="fas fa-save"></i> Guardar Cambios
        </button>
      </div>

    </form>
  </div>

</div>

</x-admin-layout>