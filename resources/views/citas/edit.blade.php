<x-admin-layout title="Editar Cita Médica" :breadcrumbs="[
    [
      'name'=> 'Dashboard',
      'href' => route('admin.dashboard'),
    ],
    [
      'name'=>'Citas Médicas',
      'href' => route('admin.citas.index'),
    ],
    [
      'name'=>'Editar Cita #' . $cita->id,
    ],
]">

<div class="max-w-4xl mx-auto"
     x-data="{
        fechaSeleccionada: '{{ old('fecha_hora') ? substr(old('fecha_hora'), 0, 10) : \Carbon\Carbon::parse($cita->fecha_hora)->format('Y-m-d') }}',
        fechaHora: '{{ old('fecha_hora', \Carbon\Carbon::parse($cita->fecha_hora)->format('Y-m-d H:i')) }}',
        vetId: '{{ old('veterinario_id', $cita->veterinario_id) }}',
        mascotaId: '{{ old('mascota_id', $cita->mascota_id) }}',
        motivo: '{{ addslashes(old('motivo', $cita->motivo)) }}',
        estado: '{{ old('estado', $cita->estado) }}',
        observaciones: '{{ addslashes(old('observaciones', $cita->observaciones)) }}',
        
        mascotas: {
            @foreach($mascotas as $m)
            '{{ $m->id }}': {
                nombre: '{{ addslashes($m->nombre) }}',
                especie: '{{ addslashes($m->especie) }}',
                dueno: '{{ addslashes($m->dueno_nombre) }}'
            },
            @endforeach
        },
        
        veterinariosRaw: [
            @foreach($veterinarios as $v)
            {
                id: '{{ $v->id }}',
                nombre: '{{ addslashes($v->nombre) }}',
                especialidad: '{{ addslashes($v->especialidad) }}',
                horarios: {
                    @foreach($v->horarios as $h)
                    '{{ $h->dia_semana }}': {
                        activo: {{ $h->activo ? 'true' : 'false' }},
                        inicio: '{{ substr($h->hora_inicio, 0, 5) }}',
                        fin: '{{ substr($h->hora_fin, 0, 5) }}'
                    },
                    @endforeach
                },
                citasOcupadas: [
                    @foreach($v->citas as $c)
                    @if($c->id != $cita->id)
                    '{{ substr(str_replace('T', ' ', $c->fecha_hora), 0, 16) }}',
                    @endif
                    @endforeach
                ]
            },
            @endforeach
        ],
        
        get doctoresDisponibles() {
            if (!this.fechaSeleccionada) return [];
            const [y, m, d] = this.fechaSeleccionada.split('-').map(Number);
            const dateObj = new Date(y, m - 1, d);
            const dayOfWeek = dateObj.getDay(); // 0 Domingo a 6 Sabado
            
            return this.veterinariosRaw.map(vet => {
                const horario = vet.horarios[dayOfWeek];
                if (!horario || !horario.activo) return null;
                
                const slots = [];
                let [hCurr, mCurr] = horario.inicio.split(':').map(Number);
                const [hEnd, mEnd] = horario.fin.split(':').map(Number);
                const endMinutes = hEnd * 60 + mEnd;
                
                while (hCurr * 60 + mCurr < endMinutes) {
                    const hStr = String(hCurr).padStart(2, '0');
                    const mStr = String(mCurr).padStart(2, '0');
                    const slotTime = `${hStr}:${mStr}`;
                    const targetString = `${this.fechaSeleccionada} ${slotTime}`;
                    
                    const ocupado = vet.citasOcupadas.some(c => c === targetString);
                    
                    if (!ocupado) {
                        slots.push({ hora: slotTime, value: `${this.fechaSeleccionada} ${slotTime}` });
                    }
                    
                    mCurr += 30;
                    if (mCurr >= 60) {
                        hCurr += 1;
                        mCurr -= 60;
                    }
                }
                
                if (slots.length === 0) return null;
                return { ...vet, slots };
            }).filter(Boolean);
        },

        get doctorMap() {
            const map = {};
            this.veterinariosRaw.forEach(v => map[v.id] = v);
            return map;
        },

        get doctorSeleccionado() {
            return this.doctorMap[this.vetId] || null;
        },
        get mascotaSeleccionada() {
            return this.mascotas[this.mascotaId] || null;
        },
        get fechaFormateada() {
            if (!this.fechaHora) return '--/--/----';
            const partes = this.fechaHora.split(' ')[0].split('-');
            if (partes.length !== 3) return '--/--/----';
            return `${partes[2]}/${partes[1]}/${partes[0]}`;
        },
        get horaFormateada() {
            if (!this.fechaHora) return '--:--';
            const hora = this.fechaHora.split(' ')[1];
            if (!hora) return '--:--';
            return hora.substring(0, 5);
        },
        
        seleccionarSlot(vet_id, slot_val) {
            this.vetId = vet_id;
            this.fechaHora = slot_val;
        }
     }">
  
  <form action="{{ route('admin.citas.update', $cita) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="hidden" name="veterinario_id" :value="vetId">
    <input type="hidden" name="fecha_hora" :value="fechaHora">

    <!-- Encabezado -->
    <div class="bg-white p-4 rounded-lg border border-gray-200 mb-6 flex items-center justify-between">
      <h2 class="text-lg font-semibold text-gray-800">Editar Cita Médica #{{ $cita->id }}</h2>
      <a href="{{ route('admin.citas.index') }}" class="text-sm text-gray-600 hover:text-gray-800 border border-gray-300 rounded px-3 py-1">
        <i class="fas fa-arrow-left mr-1"></i> Volver
      </a>
    </div>

    <div class="space-y-6">
      
      <!-- COLUMNA IZQUIERDA Búsqueda de Disponibilidad y Datos -->
      
      <!-- Búsqueda de Fechas y Horarios -->
      <div class="bg-white p-5 rounded-lg border border-gray-200 space-y-4">
        <h3 class="font-semibold text-gray-800 border-b pb-2">1. Seleccionar Fecha y Especialista</h3>

        <x-validation-errors />

        <!-- Selector de Fecha -->
        <div class="max-w-xs">
          <label class="block text-sm font-medium text-gray-700 mb-1">
            <i class="fas fa-calendar-day text-blue-500 mr-1"></i> Fecha de la Consulta
          </label>
          <input type="date" x-model="fechaSeleccionada" min="{{ date('Y-m-d') }}"
                 class="w-full rounded border border-gray-300 py-2 px-3 text-sm text-gray-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
        </div>

        <!-- Listado de veterinarios Disponibles -->
        <div class="space-y-3">
          <label class="block text-sm font-medium text-gray-700">
            <i class="fas fa-user-md text-blue-500 mr-1"></i> Especialistas disponibles
          </label>

          <div x-show="doctoresDisponibles.length === 0" class="p-4 bg-gray-50 border border-dashed border-gray-300 rounded text-center text-sm text-gray-600">
            No hay doctores con horario de atención o cupos libres este día.
          </div>

          <!-- Grid de Doctores -->
          <div class="space-y-3">
            <template x-for="vet in doctoresDisponibles" :key="vet.id">
              <div class="p-4 rounded border border-gray-200 bg-white">
                <div class="flex items-center justify-between mb-2">
                  <div>
                    <span class="font-semibold text-sm text-gray-800" x-text="'Dr(a). ' + vet.nombre"></span>
                    <span class="ml-2 text-xs text-blue-600" x-text="vet.especialidad"></span>
                  </div>
                  <span class="text-xs text-gray-500"><span x-text="vet.slots.length"></span> horarios</span>
                </div>

                <!-- Grid de Horarios -->
                <div>
                  <span class="text-xs text-gray-500 block mb-1">Horarios disponibles:</span>
                  <div class="flex flex-wrap gap-2">
                    <template x-for="s in vet.slots" :key="s.value">
                      <button type="button" @click="seleccionarSlot(vet.id, s.value)"
                              :class="fechaHora === s.value && vetId === vet.id ? 'bg-blue-600 text-white border-blue-600' : 'bg-white border-gray-300 text-gray-700 hover:border-blue-400'"
                              class="px-3 py-1 rounded border text-xs cursor-pointer">
                        <span x-text="s.hora"></span>
                      </button>
                    </template>
                  </div>
                </div>
              </div>
            </template>
          </div>
        </div>

        <!-- Mensaje recordatorio de selección -->
        <div x-show="!fechaHora || !vetId" class="p-3 bg-amber-50 border border-amber-200 rounded text-amber-800 text-xs">
          <i class="fas fa-exclamation-circle mr-1"></i>
          Haga clic en uno de los horarios disponibles para confirmar la cita.
        </div>
      </div>

      <!-- Información del Paciente -->
      <div class="bg-white p-5 rounded-lg border border-gray-200 space-y-4">
        <h3 class="font-semibold text-gray-800 border-b pb-2">2. Detalles del Paciente y Motivo</h3>

        <!-- Selección de Mascota -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            <i class="fas fa-paw text-blue-500 mr-1"></i> Paciente (Mascota) <span class="text-red-500">*</span>
          </label>
          <select name="mascota_id" x-model="mascotaId" class="w-full rounded border border-gray-300 py-2 px-3 text-sm text-gray-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
            <option value="" disabled selected>-- Seleccionar paciente --</option>
            @foreach($mascotas as $mascota)
              <option value="{{ $mascota->id }}">
                {{ $mascota->nombre }} - {{ $mascota->especie }} (Dueño: {{ $mascota->dueno_nombre }})
              </option>
            @endforeach
          </select>
          @error('mascota_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Motivo de la Cita -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">
            <i class="fas fa-stethoscope text-blue-500 mr-1"></i> Motivo de la Cita <span class="text-red-500">*</span>
          </label>
          <textarea name="motivo" x-model="motivo" rows="2" placeholder="Escribe el motivo detallado de la consulta..." class="w-full rounded border border-gray-300 py-2 px-3 text-sm text-gray-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required></textarea>
          @error('motivo') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Estado -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              <i class="fas fa-flag text-blue-500 mr-1"></i> Estado <span class="text-red-500">*</span>
            </label>
            <select name="estado" x-model="estado" class="w-full rounded border border-gray-300 py-2 px-3 text-sm text-gray-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
              <option value="Programada">Programada</option>
              <option value="Completada">Completada</option>
              <option value="Cancelada">Cancelada</option>
            </select>
            @error('estado') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
          </div>

          <!-- Observaciones -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
              <i class="fas fa-file-alt text-blue-500 mr-1"></i> Notas / Recomendaciones
            </label>
            <input type="text" name="observaciones" x-model="observaciones" placeholder="Ej. Traer carnet de vacunas..." class="w-full rounded border border-gray-300 py-2 px-3 text-sm text-gray-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" />
            @error('observaciones') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
          </div>
        </div>
      </div>

      <!-- Botón de Envío -->
      <div class="flex items-center justify-end gap-3">
        <a href="{{ route('admin.citas.index') }}" class="px-4 py-2 text-sm border border-gray-300 rounded text-gray-700 hover:bg-gray-50">
          Cancelar
        </a>
        <button type="submit" :disabled="!fechaHora || !vetId || !mascotaId || !motivo"
                class="px-6 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold disabled:opacity-40 disabled:cursor-not-allowed">
          <i class="fas fa-save mr-1"></i> Guardar Cambios
        </button>
      </div>

    </div>

  </form>
</div>

</x-admin-layout>
