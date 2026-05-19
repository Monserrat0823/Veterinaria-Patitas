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
    'name'=> 'Editar',
  ]
]">  
  
  <form action="{{ route('admin.mascotas.update', $mascota) }}" method="POST">
    @csrf
    @method('PUT')
    <x-wire-card>

      {{-- Header --}}
      <div class="flex items-center gap-4 mb-6 pb-4 pt-3 border-b border-gray-200">
        <div class="flex items-center justify-center w-14 h-14 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg text-white text-2xl">
          <i class="fas fa-notes-medical"></i>
        </div>
        <div>
          <h2 class="text-xl font-bold text-gray-800">Actualizar Expediente de {{ $mascota->nombre }}</h2>
          <p class="text-sm text-gray-500">Modifique los datos clínicos de la mascota</p>
        </div>
      </div>

      <x-validation-errors />

      {{-- Contenedor de Tabs con Componentes Blade --}}
      <x-tabs active="mascota">
        <x-slot name="header">
          @php
            $errMascota = $errors->hasAny(['nombre', 'especie', 'raza', 'edad', 'sexo', 'peso', 'color']);
            $errDueno = $errors->hasAny(['dueno_nombre', 'dueno_telefono', 'dueno_correo', 'dueno_direccion']);
            $errExpediente = $errors->hasAny(['observaciones']);
          @endphp

          <x-tabs-link tab="mascota" :error="$errMascota">
            <i class="fas fa-paw text-lg"></i> Datos de la Mascota
          </x-tabs-link>
          
          <x-tabs-link tab="propietario" :error="$errDueno">
            <i class="fas fa-user text-lg"></i> Datos del dueño
          </x-tabs-link>
          
          <x-tabs-link tab="expediente" :error="$errExpediente">
            <i class="fas fa-file-medical text-lg"></i> Observaciones Generales
          </x-tabs-link>
        </x-slot>

        {{-- Tab 1: Datos de la Mascota --}}
        <x-tab-content tab="mascota">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-2">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-tag text-blue-500 mr-1"></i> Nombre de la Mascota <span class="text-red-500">*</span>
              </label>
              <x-wire-input name="nombre" placeholder="Ej: Max, Luna..." value="{{ old('nombre', $mascota->nombre) }}" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-paw text-blue-500 mr-1"></i> Especie <span class="text-red-500">*</span>
              </label>
              <x-wire-input name="especie" placeholder="Ej: Perro, Gato, Conejo..." value="{{ old('especie', $mascota->especie) }}" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-dna text-blue-500 mr-1"></i> Raza
              </label>
              <x-wire-input name="raza" placeholder="Ej: Golden Retriever, Siamés..." value="{{ old('raza', $mascota->raza) }}" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-birthday-cake text-blue-500 mr-1"></i> Edad aproximada
              </label>
              <x-wire-input name="edad" placeholder="Ej: 2 años, 6 meses..." value="{{ old('edad', $mascota->edad) }}" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-venus-mars text-blue-500 mr-1"></i> Sexo <span class="text-red-500">*</span>
              </label>
              <select name="sexo" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-sm">
                <option value="">Seleccione sexo...</option>
                <option value="Macho" {{ old('sexo', $mascota->sexo) === 'Macho' ? 'selected' : '' }}>Macho</option>
                <option value="Hembra" {{ old('sexo', $mascota->sexo) === 'Hembra' ? 'selected' : '' }}>Hembra</option>
              </select>
              @error('sexo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-weight text-blue-500 mr-1"></i> Peso (kg)
              </label>
              <x-wire-input type="number" step="0.01" name="peso" placeholder="Ej: 12.5" value="{{ old('peso', $mascota->peso) }}" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-palette text-blue-500 mr-1"></i> Color / Señas Particulares
              </label>
              <x-wire-input name="color" placeholder="Ej: Blanco con manchas negras" value="{{ old('color', $mascota->color) }}" />
            </div>
          </div>
        </x-tab-content>

        {{-- Tab 2: Datos del dueño --}}
        <x-tab-content tab="propietario">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-2">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-user-circle text-purple-500 mr-1"></i> Nombre del Dueño <span class="text-red-500">*</span>
              </label>
              <x-wire-input name="dueno_nombre" placeholder="Nombre completo" value="{{ old('dueno_nombre', $mascota->dueno_nombre) }}" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-phone text-purple-500 mr-1"></i> Teléfono de Contacto
              </label>
              <x-wire-input name="dueno_telefono" placeholder="Ej: 555-1234567" value="{{ old('dueno_telefono', $mascota->dueno_telefono) }}" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-envelope text-purple-500 mr-1"></i> Correo Electrónico
              </label>
              <x-wire-input type="email" name="dueno_correo" placeholder="correo@dominio.com" value="{{ old('dueno_correo', $mascota->dueno_correo) }}" />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-map-marker-alt text-purple-500 mr-1"></i> Dirección
              </label>
              <x-wire-input name="dueno_direccion" placeholder="Calle, número, colonia..." value="{{ old('dueno_direccion', $mascota->dueno_direccion) }}" />
            </div>
          </div>
        </x-tab-content>

        {{-- Tab 3: Observaciones Generales --}}
        <x-tab-content tab="expediente">
          <div class="grid grid-cols-1 gap-6 p-2">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-notes-medical text-teal-500 mr-1"></i> Observaciones Generales y Antecedentes Clínicos
              </label>
              <textarea name="observaciones" rows="5" placeholder="Notas sobre cirugías previas, vacunas, comportamiento en clínica, etc." class="w-full rounded-lg border border-gray-300 p-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-sm">{{ old('observaciones', $mascota->observaciones) }}</textarea>
            </div>
          </div>
        </x-tab-content>

      </x-tabs>

      <x-slot name="footer">
        <div class="flex justify-end gap-x-3">
            <x-wire-button href="{{ route('admin.mascotas.index') }}" flat>
              <i class="fas fa-arrow-left mr-2"></i> Cancelar
            </x-wire-button>
            <x-wire-button type="submit" blue>
              <i class="fas fa-save mr-2"></i> Actualizar Mascota
            </x-wire-button>
        </div>
      </x-slot>
    </x-wire-card>
  </form>
  
</x-admin-layout>
