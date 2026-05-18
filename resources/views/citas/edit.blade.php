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

<div class="max-w-7xl mx-auto"
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
    <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-200 mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 font-sans">
      <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl font-bold border border-blue-100 flex-shrink-0">
          <i class="fas fa-edit"></i>
        </div>
        <div>
          <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Editar Cita Médica #{{ $cita->id }}</h2>
          <p class="text-gray-500 text-xs mt-0.5">Modifique la fecha, el doctor o actualice el estado de la cita</p>
        </div>
      </div>
      <div>
        <a href="{{ route('admin.citas.index') }}" class="px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 font-semibold border border-gray-200 rounded-lg transition-colors text-xs flex items-center gap-2">
          <i class="fas fa-arrow-left"></i> Volver al listado
        </a>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 font-sans">
      
      <!-- COLUMNA IZQUIERDA Búsqueda de Disponibilidad y Datos -->
      <div class="lg:col-span-2 space-y-8">
        
        <!-- Búsqueda de Fechas y Horarios -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-200 transition-all space-y-6">
          <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold border border-blue-100">
              1
            </div>
            <div>
              <h3 class="text-lg font-bold text-gray-900">1. Seleccionar Fecha y Especialista</h3>
              <p class="text-xs text-gray-500">Elija el día para ver los médicos disponibles y sus horarios libres</p>
            </div>
          </div>

          <x-validation-errors />

          <!-- Selector de Fecha -->
          <div class="max-w-md">
            <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">
              <i class="fas fa-calendar-day text-blue-500 mr-1.5"></i> Fecha de la Consulta
            </label>
            <input type="date" x-model="fechaSeleccionada" min="{{ date('Y-m-d') }}"
                   class="w-full rounded-xl border border-gray-300 py-2.5 px-4 text-sm font-bold text-gray-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-xs bg-white cursor-pointer" />
          </div>

          <!-- Listado de veterinarios Disponibles -->
          <div class="space-y-4 pt-4">
            <label class="block text-xs font-bold uppercase tracking-wider text-gray-500">
              <i class="fas fa-user-md text-blue-500 mr-1.5"></i> Especialistas en turno
            </label>

            <div x-show="doctoresDisponibles.length === 0" class="p-8 bg-gray-50 rounded-2xl border border-dashed border-gray-300 text-center">
              <i class="fas fa-user-slash text-2xl text-gray-400 mb-2"></i>
              <p class="text-sm font-semibold text-gray-700">No hay doctores con horario de atención o cupos libres este día.</p>
              <p class="text-xs text-gray-500 mt-1">Por favor, intente seleccionando una fecha diferente en el calendario.</p>
            </div>

            <!-- Grid de Doctores -->
            <div class="space-y-4">
              <template x-for="vet in doctoresDisponibles" :key="vet.id">
                <div class="p-5 rounded-2xl border border-gray-200 bg-white shadow-xs transition-colors hover:border-blue-400">
                  <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                      <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-base border border-blue-100 flex-shrink-0">
                        <i class="fas fa-user-md"></i>
                      </div>
                      <div>
                        <h4 class="font-bold text-sm text-gray-900" x-text="'Dr(a). ' + vet.nombre"></h4>
                        <span class="text-xs font-medium px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 border border-blue-100" x-text="vet.especialidad"></span>
                      </div>
                    </div>
                    <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200">
                      <span x-text="vet.slots.length"></span> horarios
                    </span>
                  </div>

                  <!-- Grid de Horarios -->
                  <div>
                    <span class="text-[11px] text-gray-400 font-bold block mb-2 uppercase tracking-wider">Horarios de consulta disponibles</span>
                    <div class="flex flex-wrap gap-2">
                      <template x-for="s in vet.slots" :key="s.value">
                        <button type="button" @click="seleccionarSlot(vet.id, s.value)"
                                :class="fechaHora === s.value && vetId === vet.id ? 'bg-blue-600 text-white font-bold shadow-sm border-blue-600' : 'bg-gray-50 border-gray-200 text-gray-700 hover:bg-blue-50 hover:border-blue-300 font-medium'"
                                class="px-3 py-1.5 rounded-lg border text-xs transition-all flex items-center gap-1.5 cursor-pointer">
                          <i class="fas fa-clock text-[10px]" :class="fechaHora === s.value && vetId === vet.id ? 'text-blue-100' : 'text-blue-500'"></i>
                          <span x-text="s.hora"></span>
                          <span x-show="fechaHora === s.value && vetId === vet.id" class="ml-1"><i class="fas fa-check text-[10px]"></i></span>
                        </button>
                      </template>
                    </div>
                  </div>
                </div>
              </template>
            </div>
          </div>

          <!-- Mensaje recordatorio de selección -->
          <div x-show="!fechaHora || !vetId" class="p-4 bg-amber-50 rounded-xl border border-amber-200 text-amber-800 text-xs flex items-center gap-2 font-medium">
            <i class="fas fa-exclamation-circle text-amber-600"></i>
            Haga clic en uno de los horarios arriba disponibles para confirmar la cita.
          </div>
        </div>

        <!-- Información del Paciente -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-200 space-y-6">
          <div class="flex items-center gap-3 mb-2 pb-4 border-b border-gray-100">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold border border-blue-100">
              2
            </div>
            <div>
              <h3 class="text-lg font-bold text-gray-900">2. Detalles del Paciente y Motivo</h3>
              <p class="text-xs text-gray-500">Identifique al paciente y el propósito de la atención</p>
            </div>
          </div>

          <!-- Selección de Mascota -->
          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">
              <i class="fas fa-paw text-blue-500 mr-1.5"></i> Paciente (Mascota) <span class="text-red-500">*</span>
            </label>
            <select name="mascota_id" x-model="mascotaId" class="w-full rounded-xl border border-gray-300 py-2.5 px-4 text-sm font-medium text-gray-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-xs bg-white" required>
              <option value="" disabled selected>-- Seleccionar paciente --</option>
              @foreach($mascotas as $mascota)
                <option value="{{ $mascota->id }}">
                  {{ $mascota->nombre }} - {{ $mascota->especie }} (Dueño: {{ $mascota->dueno_nombre }})
                </option>
              @endforeach
            </select>
            @error('mascota_id') <span class="text-xs text-red-500 mt-1.5 block font-medium">{{ $message }}</span> @enderror
          </div>

          <!-- Motivo de la Cita -->
          <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">
              <i class="fas fa-stethoscope text-blue-500 mr-1.5"></i> Motivo de la Cita <span class="text-red-500">*</span>
            </label>
            <textarea name="motivo" x-model="motivo" rows="2" placeholder="Escribe el motivo detallado de la consulta..." class="w-full rounded-xl border border-gray-300 py-2.5 px-4 text-sm font-medium text-gray-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-xs bg-white" required></textarea>
            @error('motivo') <span class="text-xs text-red-500 mt-1.5 block font-medium">{{ $message }}</span> @enderror
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Estado -->
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">
                <i class="fas fa-flag text-blue-500 mr-1.5"></i> Estado Inicial <span class="text-red-500">*</span>
              </label>
              <select name="estado" x-model="estado" class="w-full rounded-xl border border-gray-300 py-2.5 px-4 text-sm font-medium text-gray-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-xs bg-white" required>
                <option value="Programada">Programada</option>
                <option value="Completada">Completada</option>
                <option value="Cancelada">Cancelada</option>
              </select>
              @error('estado') <span class="text-xs text-red-500 mt-1.5 block font-medium">{{ $message }}</span> @enderror
            </div>

            <!-- Observaciones -->
            <div>
              <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">
                <i class="fas fa-file-alt text-blue-500 mr-1.5"></i> Notas / Recomendaciones
              </label>
              <input type="text" name="observaciones" x-model="observaciones" placeholder="Ej. Traer carnet de vacunas..." class="w-full rounded-xl border border-gray-300 py-2.5 px-4 text-sm font-medium text-gray-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 shadow-xs bg-white" />
              @error('observaciones') <span class="text-xs text-red-500 mt-1.5 block font-medium">{{ $message }}</span> @enderror
            </div>
          </div>
        </div>

      </div>

      <!-- COLUMNA DERECHA-->
      <div class="lg:col-span-1">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-200 p-8 sticky top-8 flex flex-col justify-between space-y-6">
          <div class="relative z-10 space-y-6">
            <div class="flex items-center gap-3 pb-6 border-b border-gray-100">
              <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-xs font-bold">
                <i class="fas fa-receipt"></i>
              </div>
              <div>
                <h3 class="text-xl font-black text-gray-800">Resumen de Cita</h3>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200" x-text="estado"></span>
              </div>
            </div>

            <!-- Ficha de Datos  -->
            <div class="space-y-4 font-sans">
              <!-- Paciente -->
              <div class="p-4 rounded-2xl bg-gray-50/80 border border-gray-100 flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-lg flex-shrink-0">
                  <i class="fas fa-paw"></i>
                </div>
                <div class="overflow-hidden">
                  <span class="text-[11px] font-bold uppercase tracking-wider text-gray-400 block mb-0.5">Paciente asignado</span>
                  <template x-if="mascotaSeleccionada">
                    <div>
                      <strong class="text-sm font-black text-gray-800 block truncate" x-text="mascotaSeleccionada.nombre"></strong>
                      <span class="text-xs text-gray-500 block truncate" x-text="mascotaSeleccionada.especie + ' • Dueño: ' + mascotaSeleccionada.dueno"></span>
                    </div>
                  </template>
                  <template x-if="!mascotaSeleccionada">
                    <span class="text-sm font-bold text-amber-600">Ninguno seleccionado</span>
                  </template>
                </div>
              </div>

              <!-- Doctor -->
              <div class="p-4 rounded-2xl bg-gray-50/80 border border-gray-100 flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-lg flex-shrink-0">
                  <i class="fas fa-user-md"></i>
                </div>
                <div class="overflow-hidden">
                  <span class="text-[11px] font-bold uppercase tracking-wider text-gray-400 block mb-0.5">Doctor a cargo</span>
                  <template x-if="doctorSeleccionado">
                    <div>
                      <strong class="text-sm font-black text-gray-800 block truncate" x-text="doctorSeleccionado.nombre"></strong>
                      <span class="text-xs text-blue-600 font-bold block truncate" x-text="doctorSeleccionado.especialidad"></span>
                    </div>
                  </template>
                  <template x-if="!doctorSeleccionado">
                    <span class="text-sm font-bold text-amber-600">Ningún doctor seleccionado</span>
                  </template>
                </div>
              </div>

              <!-- Fecha y Hora -->
              <div class="grid grid-cols-2 gap-4">
                <div class="p-4 rounded-2xl bg-blue-50/50 border border-blue-100 text-center">
                  <i class="fas fa-calendar-day text-blue-600 mb-1 text-lg"></i>
                  <span class="text-[11px] font-bold uppercase tracking-wider text-blue-500 block">Fecha</span>
                  <strong class="text-sm font-black text-blue-950 block" x-text="fechaFormateada"></strong>
                </div>
                <div class="p-4 rounded-2xl bg-blue-50/50 border border-blue-100 text-center">
                  <i class="fas fa-clock text-blue-600 mb-1 text-lg"></i>
                  <span class="text-[11px] font-bold uppercase tracking-wider text-blue-500 block">Hora</span>
                  <strong class="text-sm font-black text-blue-950 block" x-text="horaFormateada"></strong>
                </div>
              </div>

              <!-- Motivo -->
              <div class="p-4 rounded-2xl bg-gray-50/80 border border-gray-100">
                <span class="text-[11px] font-bold uppercase tracking-wider text-gray-400 block mb-1">Motivo / Notas</span>
                <p class="text-xs font-semibold text-gray-700 italic leading-relaxed" x-text="motivo ? '“' + motivo + '”' : 'Sin motivo escrito aún...'"></p>
              </div>
            </div>
          </div>

          <!-- Botón de Envío -->
          <div class="relative z-10 pt-4 border-t border-gray-100 flex flex-col sm:flex-row gap-3">
            <a href="{{ route('admin.citas.index') }}" class="w-full sm:w-1/3 py-3 px-4 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 text-center font-bold text-sm transition-colors flex items-center justify-center">
              Cancelar
            </a>
            <button type="submit" :disabled="!fechaHora || !vetId || !mascotaId || !motivo"
                    class="w-full sm:w-2/3 py-3 px-6 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md transition-all flex items-center justify-center gap-2 disabled:opacity-40 disabled:cursor-not-allowed">
              <i class="fas fa-save"></i> Guardar Cambios
            </button>
          </div>
        </div>
      </div>

    </div>

  </form>
</div>

</x-admin-layout>
