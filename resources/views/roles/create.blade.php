<x-admin-layout title="Roles" :breadcrumbs="[
  [
    'name'=> 'Dashboard',
    'href'=> route('admin.dashboard'),
  ],
  [
    'name'=> 'Roles',
    'href'=> route('admin.roles.index'),
  ],
  [
    'name'=> 'Crear',
  ]
]">  
  
  <form action="{{route('admin.roles.store')}}" method="POST">
    @csrf
    <x-wire-card title="Nuevo Rol">
      <x-wire-input label="Nombre" name="name" placeholder="Nombre del rol" value="{{old('name')}}" />
      
      <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <x-wire-button href="{{ route('admin.roles.index') }}" flat>Cancelar</x-wire-button>
            <x-wire-button type="submit" blue>Guardar</x-wire-button>
        </div>
      </x-slot>
    </x-wire-card>
  </form>
  
</x-admin-layout>