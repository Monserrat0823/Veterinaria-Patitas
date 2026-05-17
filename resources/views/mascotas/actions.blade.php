<div class="flex items-center gap-2">
    <a href="{{ route('admin.mascotas.edit', $row) }}" class="p-1 text-blue-600 hover:text-blue-800 transition-colors" title="Editar Mascota">
        <i class="fas fa-edit text-lg"></i>
    </a>
    <form action="{{ route('admin.mascotas.destroy', $row) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar esta mascota y todo su historial?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="p-1 text-red-600 hover:text-red-800 transition-colors" title="Eliminar Mascota">
            <i class="fas fa-trash-alt text-lg"></i>
        </button>
    </form>
</div>
