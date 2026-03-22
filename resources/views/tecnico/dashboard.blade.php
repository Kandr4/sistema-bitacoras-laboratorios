<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            ⚙️ Panel Técnico
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- BIENVENIDA --}}
            <div class="bg-white shadow rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-700">
                    👋 Bienvenido {{ Auth::user()->name }}
                </h3>
                <p class="text-gray-500 mt-1">
                    Rol: <span class="font-semibold text-blue-600">{{ Auth::user()->rol }}</span>
                </p>
            </div>

            {{-- ACCIONES --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Solicitudes de software --}}
                <a href="{{ route('tecnico.solicitudes.index') }}"
                   class="bg-indigo-600 text-white p-6 rounded-xl shadow hover:bg-indigo-700 transition">
                    <h3 class="text-lg font-semibold">💻 Solicitudes de software</h3>
                    <p class="text-sm mt-2 opacity-80">Gestionar solicitudes de instalación</p>
                </a>

                {{-- Mantenimiento --}}
                <a href="{{ route('tecnico.mantenimiento.index') }}"
                   class="bg-blue-600 text-white p-6 rounded-xl shadow hover:bg-blue-700 transition">
                    <h3 class="text-lg font-semibold">🛠 Bitácora de mantenimiento</h3>
                    <p class="text-sm mt-2 opacity-80">Registrar y consultar mantenimientos</p>
                </a>

                {{-- Solicitudes de compra --}}
                <a href="{{ route('tecnico.solicitudesCompra.index') }}"
                   class="bg-purple-600 text-white p-6 rounded-xl shadow hover:bg-purple-700 transition">
                    <h3 class="text-lg font-semibold">🛒 Solicitudes de compra</h3>
                    <p class="text-sm mt-2 opacity-80">Ver y gestionar solicitudes</p>
                </a>

                {{-- Incidencias --}}
                <a href="{{ route('tecnico.incidencias.index') }}"
                   class="bg-green-600 text-white p-6 rounded-xl shadow hover:bg-green-700 transition">
                    <h3 class="text-lg font-semibold">📋 Incidencias</h3>
                    <p class="text-sm mt-2 opacity-80">Registrar y revisar incidencias</p>
                </a>

                {{-- Fallas --}}
                <a href="{{ route('tecnico.fallas.index') }}"
                   class="bg-red-600 text-white p-6 rounded-xl shadow hover:bg-red-700 transition">
                    <h3 class="text-lg font-semibold">⚠️ Fallas</h3>
                    <p class="text-sm mt-2 opacity-80">Reportar y dar seguimiento a fallas</p>
                </a>

            </div>

        </div>
    </div>
</x-app-layout>