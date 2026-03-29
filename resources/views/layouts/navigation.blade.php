<nav x-data="{ open: false }" class="bg-gradient-to-r from-blue-700 to-indigo-800 shadow-md">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Logo y nombre del sistema -->
            <div class="flex items-center gap-4">
                <!-- Logo + nombre -->
                <div class="bg-white text-blue-700 p-2 rounded-lg shadow">
                    
                </div>

                <div class="text-white">

                    <h1 class="font-bold text-lg leading-none">
                        Sistema de Bitácoras
                    </h1>

                    <p class="text-xs text-blue-200">
                        Laboratorio de Cómputo
                    </p>

                </div>


                <!-- Links -->
                <div class="hidden sm:flex space-x-6 ml-6">

                    <a href="/admin"
                       class="text-white hover:text-blue-200 font-medium transition">
                        Dashboard
                    </a>

                    <a href="{{ route('usuarios.index') }}"
                       class="text-white hover:text-blue-200 font-medium transition">
                        Usuarios
                    </a>

                    <a href="#"
                       class="text-white hover:text-blue-200 font-medium transition">
                        Bitácoras
                    </a>

                    <a href="#"
                       class="text-white hover:text-blue-200 font-medium transition">
                        Reportes
                    </a>

                </div>
            </div>


            <!-- Notificaciones + Usuario -->
            <div class="hidden sm:flex sm:items-center gap-3">

                <!-- 🔔 Campana de notificaciones -->
                @auth
                <div x-data="notifDropdown()" class="relative">
                    <button @click="toggleDropdown()" class="relative text-white hover:text-blue-200 transition p-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>

                        @if(Auth::user()->notificacionesNoLeidas() > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                {{ Auth::user()->notificacionesNoLeidas() > 9 ? '9+' : Auth::user()->notificacionesNoLeidas() }}
                            </span>
                        @endif
                    </button>

                    <!-- Dropdown -->
                    <div x-show="isOpen" @click.outside="isOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden z-50"
                         style="display: none;">

                        <div class="px-4 py-3 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                            <span class="font-semibold text-gray-700 text-sm">Notificaciones</span>
                            @if(Auth::user()->notificacionesNoLeidas() > 0)
                                <span class="text-xs text-blue-600 font-medium">{{ Auth::user()->notificacionesNoLeidas() }} nuevas</span>
                            @endif
                        </div>

                        <div class="max-h-72 overflow-y-auto">
                            @php
                                $ultimasNotifs = Auth::user()->notificaciones()->orderBy('created_at', 'desc')->take(5)->get();
                            @endphp

                            @forelse($ultimasNotifs as $notif)
                                <div class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50 transition
                                    {{ $notif->leida ? '' : 'bg-blue-50' }}">
                                    <div class="flex items-start gap-2">
                                        <span class="flex-shrink-0">
                                            @if($notif->tipo === 'solicitud_nueva') 💻
                                            @elseif($notif->tipo === 'solicitud_estado') 📬
                                            @elseif($notif->tipo === 'falla_resuelta') ✅
                                            @else 🔔
                                            @endif
                                        </span>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm {{ $notif->leida ? 'text-gray-500' : 'text-gray-800 font-medium' }} truncate">
                                                {{ $notif->mensaje }}
                                            </p>
                                            <p class="text-xs text-gray-400 mt-0.5">{{ $notif->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="px-4 py-6 text-center text-gray-400 text-sm">
                                    Sin notificaciones
                                </div>
                            @endforelse
                        </div>

                        <a href="{{ route('notificaciones.index') }}"
                           class="block px-4 py-3 text-center text-sm text-blue-600 hover:bg-blue-50 font-medium border-t border-gray-200 transition">
                            Ver todas las notificaciones
                        </a>
                    </div>
                </div>
                @endauth

                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 text-white hover:text-blue-200 transition">

                            <span class="font-medium">
                                {{ ucfirst(Auth::user()->rol) }}
                            </span>

                            <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10
                                    10.586l3.293-3.293a1 1 0
                                    111.414 1.414l-4 4a1 1 0
                                    01-1.414 0l-4-4a1 1 0
                                    010-1.414z"
                                    clip-rule="evenodd"/>
                            </svg>

                        </button>
                    </x-slot>

                    <x-slot name="content">

                        <x-dropdown-link :href="route('profile.edit')">
                            Perfil
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                this.closest('form').submit();">
                                Cerrar sesión
                            </x-dropdown-link>
                        </form>

                    </x-slot>

                </x-dropdown>

            </div>


            <!-- Botón móvil -->
            <div class="flex items-center sm:hidden gap-2">

                <!-- Campana móvil -->
                @auth
                <a href="{{ route('notificaciones.index') }}" class="relative text-white p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    @if(Auth::user()->notificacionesNoLeidas() > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-4 w-4 flex items-center justify-center">
                            {{ Auth::user()->notificacionesNoLeidas() > 9 ? '9+' : Auth::user()->notificacionesNoLeidas() }}
                        </span>
                    @endif
                </a>
                @endauth

                <button @click="open = ! open"
                    class="text-white hover:text-gray-200">

                    <svg class="h-6 w-6" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"/>

                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"/>

                    </svg>

                </button>

            </div>

        </div>
    </div>


    <!-- Menú responsive -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-indigo-800">

        <div class="px-4 pt-2 pb-3 space-y-2">

            <a href="{{ route('dashboard') }}"
               class="block text-white hover:text-blue-200">
                Dashboard
            </a>

            <a href="{{ route('usuarios.index') }}"
               class="block text-white hover:text-blue-200">
                Usuarios
            </a>

            <a href="#"
               class="block text-white hover:text-blue-200">
                Bitácoras
            </a>

            <a href="#"
               class="block text-white hover:text-blue-200">
                Reportes
            </a>

            <a href="{{ route('notificaciones.index') }}"
               class="block text-white hover:text-blue-200">
                🔔 Notificaciones
                @auth
                    @if(Auth::user()->notificacionesNoLeidas() > 0)
                        <span class="bg-red-500 text-white text-xs rounded-full px-2 py-0.5 ml-1">
                            {{ Auth::user()->notificacionesNoLeidas() }}
                        </span>
                    @endif
                @endauth
            </a>

        </div>

    </div>

    <script>
    function notifDropdown() {
        return {
            isOpen: false,
            toggleDropdown() {
                this.isOpen = !this.isOpen;
            }
        }
    }
    </script>

</nav>