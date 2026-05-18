<x-admin-layout title="Roles y Permisos" :breadcrumbs="[
  [
    'name' => 'Dashboard',
    'href' => route('admin.dashboard')
  ],
  [
    'name' => 'Roles y Permisos',
  ]
]">

<x-slot name="action">
  <x-wire-button blue href="{{ route('admin.roles.create') }}" class="shadow-sm font-bold">
    <i class="fas fa-plus mr-2 text-xs"></i>
    Crear Rol
  </x-wire-button>
</x-slot>

<div class="p-6 bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden font-sans" x-data="{ search: '' }">
    
    <!-- Encabezado y Buscador -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6 pb-6 border-b border-gray-100">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 border border-blue-100 flex-shrink-0 text-xl font-bold">
                <i class="fas fa-user-shield"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900 tracking-tight">Gestión de Roles del Sistema</h2>
                <p class="text-xs text-gray-500 mt-0.5 font-medium">Administre los niveles de acceso y privilegios de los usuarios</p>
            </div>
        </div>

        <div class="w-full sm:w-80">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 text-sm">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" x-model="search" placeholder="Buscar rol por nombre..." 
                       class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-300 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all bg-white shadow-xs">
            </div>
        </div>
    </div>

    <!-- Tabla de Roles -->
    <div class="overflow-x-auto">
        <table class="w-full whitespace-nowrap text-left">
            <thead>
                <tr class="text-xs font-bold tracking-wider text-gray-500 uppercase border-b border-gray-200 bg-gray-50/80">
                    @foreach($columns as $column)
                        <th class="px-6 py-3.5">{{ $column['label'] }}</th>
                    @endforeach
                    <th class="px-6 py-3.5 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @foreach($rows as $row)
                    <tr class="hover:bg-blue-50/30 transition-colors" x-show="search === '' || '{{ strtolower($row->name ?? '') }}'.includes(search.toLowerCase())">
                        @foreach($columns as $column)
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                @if($column['field'] === 'name')
                                    <span class="font-bold text-gray-900 text-base">{{ $row->name }}</span>
                                @elseif($column['field'] === 'id')
                                    <span class="text-xs font-mono font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded-md border border-gray-200">#{{ $row->id }}</span>
                                @elseif(isset($column['format']))
                                    <span class="text-gray-600">{{ $column['format']($row->{$column['field']}) }}</span>
                                @else
                                    {{ $row->{$column['field']} }}
                                @endif
                            </td>
                        @endforeach
                        <td class="px-6 py-4 text-sm text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.roles.edit', $row) }}" class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors" title="Editar Rol">
                                    <i class="fas fa-edit text-base"></i>
                                </a>
                                <form action="{{ route('admin.roles.destroy', $row) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este rol del sistema?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors cursor-pointer" title="Eliminar Rol">
                                        <i class="fas fa-trash text-base"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

</x-admin-layout>