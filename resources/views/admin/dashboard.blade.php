<x-app-layout>

    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 
                    text-white p-6 rounded-xl shadow-lg flex flex-col md:flex-row md:justify-between">

            <div>
                <h2 class="text-3xl font-bold">
                    Sistema de Bitácoras
                </h2>
                <p class="text-blue-100 mt-1">
                    Control y gestión de laboratorios
                </p>
            </div>

            <div class="mt-4 md:mt-0 text-sm md:text-right">
                <p>👤 {{ Auth::user()->name }}</p>
                <p>Rol: <b>{{ ucfirst(Auth::user()->rol) }}</b></p>
            </div>

        </div>
    </x-slot>


    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4">

            {{-- BIENVENIDA --}}
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    Panel de Administración
                </h1>
                <p class="text-gray-600">
                    Administra todos los módulos del sistema desde aquí
                </p>
            </div>

            {{-- GRID DE MODULOS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Usuarios --}}
                <a href="{{ route('usuarios.index') }}" 
                   class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border-l-4 border-blue-500">
                    <h3 class="text-lg font-semibold text-gray-800">👥 Usuarios</h3>
                    <p class="text-gray-500 text-sm mt-1">Administrar usuarios del sistema</p>
                </a>

                {{-- Laboratorios --}}
                <a href="{{ url('/admin/laboratorios') }}" 
                   class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border-l-4 border-yellow-500">
                    <h3 class="text-lg font-semibold text-gray-800">🏫 Laboratorios</h3>
                    <p class="text-gray-500 text-sm mt-1">Gestionar laboratorios</p>
                </a>

                {{-- Solicitudes Software --}}
                <a href="{{ route('admin.solicitudes.index') }}" 
                   class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border-l-4 border-indigo-500">
                    <h3 class="text-lg font-semibold text-gray-800">💻 Software</h3>
                    <p class="text-gray-500 text-sm mt-1">Solicitudes de software</p>
                </a>

                {{-- Mantenimiento --}}
                <a href="{{ route('admin.mantenimiento.index') }}" 
                   class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border-l-4 border-green-500">
                    <h3 class="text-lg font-semibold text-gray-800">🛠️ Mantenimiento</h3>
                    <p class="text-gray-500 text-sm mt-1">Bitácora de mantenimiento</p>
                </a>

                {{-- Solicitudes Compra --}}
                <a href="{{ route('admin.solicitudesCompra.index') }}" 
                   class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border-l-4 border-blue-400">
                    <h3 class="text-lg font-semibold text-gray-800">🛒 Compras</h3>
                    <p class="text-gray-500 text-sm mt-1">Solicitudes de compra</p>
                </a>

                {{-- Incidencias --}}
                <a href="{{ route('admin.incidencias.index') }}" 
                   class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border-l-4 border-red-500">
                    <h3 class="text-lg font-semibold text-gray-800">⚠️ Incidencias</h3>
                    <p class="text-gray-500 text-sm mt-1">Gestión de incidencias</p>
                </a>

                {{-- Equipos --}}
                <a href="{{ route('admin.equipos.index') }}" 
                   class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border-l-4 border-purple-500">
                    <h3 class="text-lg font-semibold text-gray-800">🖥️ Equipos</h3>
                    <p class="text-gray-500 text-sm mt-1">Administrar equipos</p>
                </a>

            </div>

        </div>
    </div>

</x-app-layout>