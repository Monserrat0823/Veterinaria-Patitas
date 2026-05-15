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
    'name'=> 'Editar',
  ]
]">  
  <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
    <form action="{{route('admin.roles.update',$role)}}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-4">
        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nombre</label>
        <input type="text" id="name" name="name" placeholder="Nombre del rol" value="{{old('name',$role->name)}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        @error('name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex justify-end mt-4">
        <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">Actualizar</button>
      </div>

    </form>
  </div>
</x-admin-layout>