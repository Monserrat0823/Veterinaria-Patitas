<div class="flex items-center justify-end gap-2">
    <a href="{{ route('admin.citas.edit', $row) }}" class="p-1.5 text-blue-600 hover:text-blue-800 transition-colors" title="Editar Cita">
        <i class="fas fa-edit text-lg"></i>
    </a>
    <form action="{{ route('admin.citas.destroy', $row) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de cancelar y eliminar esta cita médica?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="p-1.5 text-red-600 hover:text-red-800 transition-colors" title="Eliminar Cita">
            <i class="fas fa-trash-alt text-lg"></i>
        </button>
    </form>
</div>
