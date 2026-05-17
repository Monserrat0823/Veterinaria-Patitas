<x-admin-layout title="Mascotas" :breadcrumbs="[
    [
      'name'=> 'Dashboard',
      'href' => route('admin.dashboard'),
    ],
    [
      'name'=>'Mascotas',
    ],
]">

<x-slot name="action">
  <x-wire-button blue href="{{ route('admin.mascotas.create') }}" class="shadow-md">
    <i class="fas fa-plus mr-2"></i>
    Agregar Mascota
  </x-wire-button>
</x-slot>

<div class="p-6 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden" x-data="{ search: '' }">
    
    <!-- AlpineJS Header & Search Input -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6 pb-4 border-b border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 shadow-inner">
                <i class="fas fa-paw text-2xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Listado General de Mascotas</h2>
                <p class="text-xs text-gray-500">Administre el registro y expediente de las mascotas de la clínica</p>
            </div>
        </div>

        <div class="w-full sm:w-80">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" x-model="search" placeholder="Buscar por nombre, especie, dueño..." 
                       class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all shadow-sm">
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full whitespace-nowrap text-left">
            <thead>
                <tr class="text-xs font-bold tracking-wider text-gray-500 uppercase border-b bg-gray-50/75">
                    @foreach($columns as $column)
                        <th class="px-6 py-4">{{ $column['label'] }}</th>
                    @endforeach
                    <th class="px-6 py-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @foreach($mascotas as $row)
                    <tr class="hover:bg-indigo-50/30 transition-colors" 
                        x-show="search === '' || 
                                '{{ strtolower($row->nombre ?? '') }}'.includes(search.toLowerCase()) || 
                                '{{ strtolower($row->especie ?? '') }}'.includes(search.toLowerCase()) || 
                                '{{ strtolower($row->raza ?? '') }}'.includes(search.toLowerCase()) || 
                                '{{ strtolower($row->dueno_nombre ?? '') }}'.includes(search.toLowerCase())">
                        @foreach($columns as $column)
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                @if($column['field'] === 'nombre')
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs">
                                            {{ substr($row->nombre, 0, 1) }}
                                        </div>
                                        <span class="font-bold text-gray-900">{{ $row->nombre }}</span>
                                    </div>
                                @elseif($column['field'] === 'sexo')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $row->sexo === 'Macho' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                        <i class="fas {{ $row->sexo === 'Macho' ? 'fa-mars' : 'fa-venus' }} mr-1"></i> {{ $row->sexo }}
                                    </span>
                                @elseif(isset($column['format']))
                                    {{ $column['format']($row->{$column['field']}) }}
                                @else
                                    {{ $row->{$column['field']} }}
                                @endif
                            </td>
                        @endforeach
                        <td class="px-6 py-4 text-sm text-right">
                            @include('mascotas.actions', ['row' => $row])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

</x-admin-layout>
