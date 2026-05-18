<div class="flex items-center justify-end gap-2">
    <a href="{{ route('admin.mascotas.historial', $row) }}" class="px-2.5 py-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold flex items-center gap-1.5 shadow-sm transition-all" title="Ver Historial Clínico">
        <i class="fas fa-notes-medical"></i> Historial
    </a>
    <a href="{{ route('admin.mascotas.edit', $row) }}" class="p-1.5 text-blue-600 hover:text-blue-800 transition-colors" title="Editar Mascota">
        <i class="fas fa-edit text-lg"></i>
    </a>
    <form action="{{ route('admin.mascotas.destroy', $row) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar esta mascota y todo su historial?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="p-1.5 text-red-600 hover:text-red-800 transition-colors" title="Eliminar Mascota">
            <i class="fas fa-trash-alt text-lg"></i>
        </button>
    </form>
</div>
