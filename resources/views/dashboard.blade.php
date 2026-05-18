<x-admin-layout title="Inicio (Dashboard)" :breadcrumbs="[
    [
      'name'=> 'Dashboard',
    ],
]">

<div class="max-w-5xl mx-auto space-y-8 font-sans pb-12">
    <div class="py-2 border-b border-gray-200 pb-6 mb-8">
    <span class="text-xs font-bold uppercase tracking-wider text-blue-600 block mb-1">Sistema de Gestión Médica</span>
    <h1 class="text-3xl font-black text-gray-900 tracking-tight">¡Bienvenido, {{ auth()->user()->name ?? 'Administrador' }}!</h1>
    <p class="text-gray-500 text-sm mt-0.5">Resumen de registros y citas programadas en la clínica.</p>
  </div>

  <!--Tarjetas de Indicadores -->
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
    
    <!-- Mascotas -->
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs flex items-center gap-4">
      <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl font-bold flex-shrink-0">
        <i class="fas fa-paw"></i>
      </div>
      <div>
        <span class="text-xs uppercase font-bold text-gray-400 block tracking-wider">Mascotas</span>
        <strong class="text-3xl font-black text-gray-900 block mt-0.5">{{ $totalMascotas ?? 0 }}</strong>
      </div>
    </div>

    <!-- Veterinarios -->
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs flex items-center gap-4">
      <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl font-bold flex-shrink-0">
        <i class="fas fa-user-md"></i>
      </div>
      <div>
        <span class="text-xs uppercase font-bold text-gray-400 block tracking-wider">Veterinarios</span>
        <strong class="text-3xl font-black text-gray-900 block mt-0.5">{{ $totalVeterinarios ?? 0 }}</strong>
      </div>
    </div>

    <!-- Citas -->
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs flex items-center gap-4">
      <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl font-bold flex-shrink-0">
        <i class="fas fa-calendar-check"></i>
      </div>
      <div>
        <span class="text-xs uppercase font-bold text-gray-400 block tracking-wider">Citas Programadas</span>
        <strong class="text-3xl font-black text-gray-900 block mt-0.5">{{ $citasProgramadas ?? 0 }}</strong>
      </div>
    </div>

  </div>

</div>

</x-admin-layout>