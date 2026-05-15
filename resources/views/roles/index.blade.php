<x-admin-layout title="Roles" :breadcrumb="[
  [
    'name' => 'Dashboard',
    'href' => route('admin.dashboard')
  ],
  [
    'name' => 'Roles',
  ]
]">

<x-slot:actions>
  <a href="{{route('admin.roles.create')}}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 focus:outline-none">
    <i class="fas fa-plus mr-2"></i>
    Crear rol
  </a>
</x-slot:actions>

</x-admin-layout>