@if ($errors->any())
  <div class="mb-6 p-4 rounded-xl bg-red-50 border-l-4 border-red-500 text-red-700 shadow-sm flex items-start gap-3">
    <i class="fas fa-exclamation-circle text-xl text-red-500 mt-0.5"></i>
    <div>
      <h3 class="font-bold text-base">No se pudo guardar la información</h3>
      <p class="text-xs text-red-600 mb-2">Por favor, complete todos los campos obligatorios o corrija los siguientes errores:</p>
      <ul class="list-disc ml-5 text-xs space-y-1 font-medium text-red-800">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  </div>
@endif
