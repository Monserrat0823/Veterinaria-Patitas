        <?php
        //arreglo de icons KEY-VALUE
        $links = [
            ['name' => 'DASHBOARD', 'icon' => 'fa-solid fa-gauge', 'href' => route('admin.dashboard'), 'active' => request()->routeIs('admin.dashboard')],
            [
                'header' => 'Gestion',
            ],
        
            [
                'name' => 'Roles y permisos',
                'icon' => 'fa-solid fa-shield-halved',
                'href' => route('admin.roles.index'),
                'active' => request()->routeIs('admin.roles.*'),
            ],

            [
                'name'=> 'Usuarios',
                'icon' => 'fa-solid fa-users',
                'href'=> route('admin.users.index'),
                'active'=> request()->routeIs('admin.users.*'),
            ],

            [
                'name'=> 'Veterinarios',
                'icon' => 'fa-solid fa-user-md',
                'href'=> route('admin.veterinarios.index'), 
                'active'=> request()->routeIs('admin.veterinarios.*'),
            ],

            [
                'name'=> 'Mascotas',
                'icon' => 'fa-solid fa-user-injured',
                'href'=> route('admin.mascotas.index'), 
                'active'=> request()->routeIs('admin.mascotas.*'),
            ],

            [
                'name'=> 'Citas',
                'icon' => 'fa-solid fa-calendar-check',
                'href'=> route('admin.citas.index'), 
                'active'=> request()->routeIs('admin.citas.*'),
            ],

        ];
        
        ?>
        <aside id="top-bar-sidebar"
            class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0 font-poppins"
            aria-label="Sidebar">
            <div class="h-full px-3 py-4 overflow-y-auto bg-gradient-to-b from-cyan-500 to-blue-700 shadow-2xl">
                <a href="" class="flex items-center ps-2.5 mb-5">
                     
                    <span class="self-center text-lg text-white text-2xl tracking-wide font-semibold whitespace-nowrap">Veterinaria Patitas</span>
                </a>
                <ul class="space-y-2 font-medium">
                    @foreach ($links as $link)
                        <li>
                            {{-- -REVISA SI EXITE --}}
                            @isset($link['header'])
                                <div class="px-2 py-1 text-xs font-semibold text-blue-100 uppercase tracking-wider">
                                    {{ $link['header'] }}

                                </div>
                            @else
                                {{-- -REVISA SI EXISTE UNA LLEVE /PROPIEDAD LLAMADA submenu --}}
                                @isset($link['submenu'])
                                    <button type="button"
                                        class="flex items-center w-full justify-between px-2 py-1.5 text-body rounded-base hover:bg-blue-300 hover:text-blue-500 group"
                                        aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                                        <span class="w-6 h-6 inline-flex items-center justify-center text-gray-500">
                                            <i class="{{ $link['icon'] }}">
                                            </i> </span>
                                        <span
                                            class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ $link['name'] }}</span>
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m19 9-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <ul id="dropdown-example" class="hidden py-2 space-y-2">
                                        @foreach ($link['submenu'] as $item)
                                            <li>
                                                <a href="{{ $item['href'] }}"
                                                    class="pl-10 flex items-center px-2 py-1.5 text-body rounded-base hover:bg-blue-300 hover:text-blue-500 group">{{ $item['name'] }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <a href="{{ $link['href'] }}"
                                        class="flex items-center px-3 py-2.5 text-body hover:bg-white/20 hover:text-white transition-all duration-300 group {{ $link['active'] ? 'bg-white/25 text-white shadow-lg rounded-base' : 'text-white/90' }}">
                                        <span class="w-6 h-6 inline-flex items-center justify-center text-white">
                                            <i class="{{ $link['icon'] }}">
                                            </i> </span>


                                        <span class="ms-3">{{ $link['name'] }}</span>
                                    </a>
                                @endisset
                            @endisset

                        </li>
                    @endforeach

                </ul>
            </div>
        </aside>
