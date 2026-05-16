<x-admin-layout title="Citas" :breadcrumbs="[
    [
      'name'=> 'Dashboard',
      'href' => route('admin.dashboard'),
    ],
    [
      'name'=>'Citas',
    ],
]">
  <div class="p-4 bg-white rounded-lg shadow-xs">
    <h2 class="text-lg font-semibold">Lista de Citas</h2>
    <!-- Acciones -->
    <div>
        <a href="{{ route('admin.citas.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg">
            Nueva Cita
        </a>
    </div>
  </div>
</x-admin-layout>
