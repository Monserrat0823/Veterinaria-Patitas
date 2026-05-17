<x-admin-layout title="Citas" :breadcrumbs="[
    [
      'name'=> 'Dashboard',
      'href' => route('admin.dashboard'),
    ],
    [
      'name'=>'Citas Médicas',
    ],
]">

<x-slot name="action">
  <x-wire-button blue href="{{ route('admin.citas.create') }}" class="shadow-md">
    <i class="fas fa-plus mr-2"></i>
    Agendar Cita
  </x-wire-button>
</x-slot>

<div class="p-6 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden" x-data="{ search: '' }">
    
    <!-- AlpineJS Header & Search Input -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6 pb-4 border-b border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 shadow-inner">
                <i class="fas fa-calendar-check text-2xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Listado General de Citas Médicas</h2>
                <p class="text-xs text-gray-500">Gestione y supervise la agenda de consultas, vacunas y cirugías</p>
            </div>
        </div>

        <div class="w-full sm:w-80">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" x-model="search" placeholder="Buscar por mascota, doctor o motivo..." 
                       class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-200 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all shadow-sm">
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
                @foreach($citas as $row)
                    <tr class="hover:bg-blue-50/30 transition-colors" 
                        x-show="search === '' || 
                                '{{ strtolower($row->mascota->nombre ?? '') }}'.includes(search.toLowerCase()) || 
                                '{{ strtolower($row->veterinario->nombre ?? '') }}'.includes(search.toLowerCase()) || 
                                '{{ strtolower($row->motivo ?? '') }}'.includes(search.toLowerCase())">
                        @foreach($columns as $column)
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                @if($column['field'] === 'estado')
                                    @if($row->estado === 'Programada')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                            <i class="fas fa-clock mr-1.5"></i> Programada
                                        </span>
                                    @elseif($row->estado === 'Completada')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1.5"></i> Completada
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1.5"></i> Cancelada
                                        </span>
                                    @endif
                                @elseif(isset($column['format']))
                                    {{ $column['format']($row) }}
                                @else
                                    {{ $row->{$column['field']} }}
                                @endif
                            </td>
                        @endforeach
                        <td class="px-6 py-4 text-sm text-right">
                            @include('citas.actions', ['row' => $row])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

</x-admin-layout>
