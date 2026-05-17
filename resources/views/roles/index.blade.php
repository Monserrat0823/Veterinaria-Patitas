<x-admin-layout title="Roles" :breadcrumb="[
  [
    'name' => 'Dashboard',
    'href' => route('admin.dashboard')
  ],
  [
    'name' => 'Roles',
  ]
]">

<x-slot name="action">
  <x-wire-button blue href="{{route('admin.roles.create')}}">
    <i class="fas fa-plus mr-2"></i>
    Crear rol
  </x-wire-button>
</x-slot>

<div class="p-4 bg-white rounded-lg shadow-xs overflow-x-auto" x-data="{ search: '' }">
    
    <div class="mb-4">
        <input type="text" x-model="search" placeholder="Buscar rol..." class="w-full sm:w-1/3 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
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
            @foreach($rows as $row)
                <tr class="text-gray-700" x-show="search === '' || '{{ strtolower($row->name ?? '') }}'.includes(search.toLowerCase())">
                    @foreach($columns as $column)
                        <td class="px-4 py-3 text-sm">
                            @if(isset($column['format']))
                                {{ $column['format']($row->{$column['field']}) }}
                            @else
                                {{ $row->{$column['field']} }}
                            @endif
                        </td>
                    @endforeach
                    <td class="px-4 py-3 text-sm flex gap-2">
                        <a href="{{ route('admin.roles.edit', $row) }}" class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.roles.destroy', $row) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este rol?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>



</x-admin-layout>