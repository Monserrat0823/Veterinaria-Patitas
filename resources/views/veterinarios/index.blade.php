<x-admin-layout title="Veterinarios" :breadcrumb="[
  [
    'name' => 'Dashboard',
    'href' => route('admin.dashboard')
  ],
  [
    'name' => 'Veterinarios',
  ]
]">

<x-slot name="action">
  <x-wire-button blue href="{{ route('admin.veterinarios.create') }}">
    <i class="fas fa-plus mr-2"></i>
    Agregar Veterinario
  </x-wire-button>
</x-slot>

<div class="p-4 bg-white rounded-lg shadow-xs overflow-x-auto" x-data="{ search: '' }">
    
    <div class="mb-4">
        <input type="text" x-model="search" placeholder="Buscar veterinario..." class="w-full sm:w-1/3 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
    </div>

    <table class="w-full whitespace-no-wrap">
        <thead>
            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                @foreach($columns as $column)
                    <th class="px-4 py-3">{{ $column['label'] }}</th>
                @endforeach
                <th class="px-4 py-3">Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y">
            @foreach($veterinarios as $row)
                <tr class="text-gray-700" x-show="search === '' || '{{ strtolower($row->nombre ?? '') }}'.includes(search.toLowerCase())">
                    @foreach($columns as $column)
                        <td class="px-4 py-3 text-sm">
                            @if(isset($column['format']))
                                {{ $column['format']($row->{$column['field']}) }}
                            @else
                                {{ $row->{$column['field']} }}
                            @endif
                        </td>
                    @endforeach
                    <td class="px-4 py-3 text-sm flex items-center gap-3">
                        <a href="{{ route('admin.veterinarios.horarios', $row) }}" class="px-2.5 py-1 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-lg text-xs flex items-center gap-1.5 transition-all shadow-sm" title="Configurar Horario de Disponibilidad">
                            <i class="fas fa-clock"></i> Horarios
                        </a>
                        <a href="{{ route('admin.veterinarios.edit', $row) }}" class="text-blue-500 hover:text-blue-700" title="Editar Doctor">
                            <i class="fas fa-edit text-lg"></i>
                        </a>
                        <form action="{{ route('admin.veterinarios.destroy', $row) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este veterinario?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700" title="Eliminar Doctor">
                                <i class="fas fa-trash text-lg"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

</x-admin-layout>
