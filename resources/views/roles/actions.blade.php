<div class="flex items-center gap-x-2">
    <a href="{{route('admin.roles.edit', $role)}}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded text-xs px-3 py-1.5 focus:outline-none">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>

   <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="inline">
        @csrf 
        @method('DELETE')
        <button type="submit" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded text-xs px-3 py-1.5 focus:outline-none">
            <i class="fa-solid fa-trash"></i>
        </button>
    </form>
</div>