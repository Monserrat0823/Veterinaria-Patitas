<x-admin-layout title="Mascotas" :breadcrumbs="[
  [
    'name'=> 'Dashboard',
    'href'=> route('admin.dashboard'),
  ],
  [
    'name'=> 'Mascotas',
    'href'=> route('admin.mascotas.index'),
  ],
  [
    'name'=> 'Crear',
  ]
]">  
  
  <form action="{{ route('admin.mascotas.store') }}" method="POST">
    @csrf
    <x-wire-card>

      {{-- Header decorativo --}}
      <div class="flex items-center gap-4 mb-6 pb-4 pt-2 border-b border-gray-200">
        <div class="flex items-center justify-center w-14 h-14 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg text-white text-2xl">
          <i class="fas fa-paw"></i>
        </div>
        <div>
          <h2 class="text-xl font-bold text-gray-800">Registro de Nuevo Paciente (Mascota)</h2>
          <p class="text-sm text-gray-500">Complete la ficha clínica y los datos del propietario</p>
        </div>
      </div>

      {{-- Contenedor de Tabs con Alpine.js --}}
      <div x-data="{ tab: 'paciente' }">
        
        {{-- Navegación de Tabs --}}
        <div class="flex border-b border-gray-200 mb-6 gap-2 overflow-x-auto">
          <button type="button" @click="tab = 'paciente'" 
                  :class="{ 'border-indigo-600 text-indigo-600 border-b-2 font-bold': tab === 'paciente', 'text-gray-500 hover:text-gray-700': tab !== 'paciente' }" 
                  class="px-5 py-3 text-sm font-medium transition-all flex items-center gap-2 whitespace-nowrap outline-none focus:outline-none">
            <i class="fas fa-paw text-lg"></i> Datos de la Mascota
          </button>
          
          <button type="button" @click="tab = 'propietario'" 
                  :class="{ 'border-indigo-600 text-indigo-600 border-b-2 font-bold': tab === 'propietario', 'text-gray-500 hover:text-gray-700': tab !== 'propietario' }" 
                  class="px-5 py-3 text-sm font-medium transition-all flex items-center gap-2 whitespace-nowrap outline-none focus:outline-none">
            <i class="fas fa-user text-lg"></i> Datos del dueño
          </button>
          
          <button type="button" @click="tab = 'expediente'" 
                  :class="{ 'border-indigo-600 text-indigo-600 border-b-2 font-bold': tab === 'expediente', 'text-gray-500 hover:text-gray-700': tab !== 'expediente' }" 
                  class="px-5 py-3 text-sm font-medium transition-all flex items-center gap-2 whitespace-nowrap outline-none focus:outline-none">
            <i class="fas fa-file-medical text-lg"></i> Observaciones Generales
          </button>
        </div>

        {{-- Tab 1: Datos del Paciente --}}
        <div x-show="tab === 'paciente'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-2">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-tag text-indigo-500 mr-1"></i> Nombre de la Mascota <span class="text-red-500">*</span>
              </label>
              <x-wire-input name="nombre" placeholder="Ej: Max, Luna..." value="{{ old('nombre') }}" required />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-paw text-indigo-500 mr-1"></i> Especie <span class="text-red-500">*</span>
              </label>
              <x-wire-input name="especie" placeholder="Ej: Perro, Gato, Conejo..." value="{{ old('especie') }}" required />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-dna text-indigo-500 mr-1"></i> Raza
              </label>
              <x-wire-input name="raza" placeholder="Ej: Golden Retriever, Siamés..." value="{{ old('raza') }}" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-calendar-alt text-indigo-500 mr-1"></i> Fecha de Nacimiento
              </label>
              <x-wire-input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-venus-mars text-indigo-500 mr-1"></i> Sexo <span class="text-red-500">*</span>
              </label>
              <select name="sexo" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 shadow-sm" required>
                <option value="">Seleccione sexo...</option>
                <option value="Macho" {{ old('sexo') === 'Macho' ? 'selected' : '' }}>Macho</option>
                <option value="Hembra" {{ old('sexo') === 'Hembra' ? 'selected' : '' }}>Hembra</option>
              </select>
              @error('sexo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-weight text-indigo-500 mr-1"></i> Peso (kg)
              </label>
              <x-wire-input type="number" step="0.01" name="peso" placeholder="Ej: 12.5" value="{{ old('peso') }}" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-palette text-indigo-500 mr-1"></i> Color / Señas Particulares
              </label>
              <x-wire-input name="color" placeholder="Ej: Blanco con manchas negras" value="{{ old('color') }}" />
            </div>
          </div>
        </div>

        {{-- Tab 2: Datos del Propietario --}}
        <div x-show="tab === 'propietario'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-cloak>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-2">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-user-circle text-purple-500 mr-1"></i> Nombre del Propietario <span class="text-red-500">*</span>
              </label>
              <x-wire-input name="dueno_nombre" placeholder="Nombre completo" value="{{ old('dueno_nombre') }}" required />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-phone text-purple-500 mr-1"></i> Teléfono de Contacto
              </label>
              <x-wire-input name="dueno_telefono" placeholder="Ej: 555-1234567" value="{{ old('dueno_telefono') }}" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-envelope text-purple-500 mr-1"></i> Correo Electrónico
              </label>
              <x-wire-input type="email" name="dueno_correo" placeholder="correo@dominio.com" value="{{ old('dueno_correo') }}" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-map-marker-alt text-purple-500 mr-1"></i> Dirección
              </label>
              <x-wire-input name="dueno_direccion" placeholder="Calle, número, colonia..." value="{{ old('dueno_direccion') }}" />
            </div>
          </div>
        </div>

        {{-- Tab 3: Observaciones Generales --}}
        <div x-show="tab === 'expediente'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-cloak>
          <div class="grid grid-cols-1 gap-6 p-2">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-notes-medical text-teal-500 mr-1"></i> Observaciones Generales y Antecedentes Clínicos
              </label>
              <textarea name="observaciones" rows="5" placeholder="Notas sobre cirugías previas, vacunas, comportamiento en clínica, etc." class="w-full rounded-lg border border-gray-300 p-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 shadow-sm">{{ old('observaciones') }}</textarea>
            </div>
          </div>
        </div>

      </div>

      <x-slot name="footer">
        <div class="flex justify-end gap-x-3">
            <x-wire-button href="{{ route('admin.mascotas.index') }}" flat>
              <i class="fas fa-arrow-left mr-2"></i> Cancelar
            </x-wire-button>
            <x-wire-button type="submit" blue>
              <i class="fas fa-save mr-2"></i> Guardar Paciente
            </x-wire-button>
        </div>
      </x-slot>
    </x-wire-card>
  </form>
  
</x-admin-layout>
