<nav class="fixed top-0 z-30 w-full bg-white border-b border-gray-200 h-14 flex items-center justify-between px-4 sm:px-6">
    <div class="flex items-center sm:ml-64">
    </div>

    <div class="flex items-center gap-3">
        <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'Administrador' }}</span>
        
        <!-- Botón de Cerrar Sesión -->
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">
                Cerrar Sesión
            </button>
        </form>
    </div>
</nav>
