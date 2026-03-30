<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        🏫 Panel Docente
    </h2>
</x-slot>

<div class="py-10">
    <div class="max-w-7xl mx-auto px-4 space-y-6">

        {{-- BIENVENIDA --}}
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="text-lg font-semibold text-gray-700">
                👋 Bienvenido {{ Auth::user()->nombre }} {{ Auth::user()->paterno }}
            </h3>
            <p class="text-gray-500 mt-1">
                Rol: <span class="font-semibold text-blue-600">{{ ucfirst(Auth::user()->rol) }}</span>
            </p>
        </div>

        {{-- BOTONERA (GRID RESPONSIVA) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            {{-- Solicitar Software --}}
            <a href="{{ route('profesor.solicitudes.create') }}"
               class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all border-t-4 border-blue-500 flex flex-col items-center text-center">
                <div class="text-3xl mb-3">📥</div>
                <h3 class="text-lg font-bold text-gray-800">Solicitar Software</h3>
                <p class="text-gray-500 text-sm mt-2">Realizar una nueva petición de software para laboratorio</p>
            </a>

            {{-- Ver Solicitudes --}}
            <a href="{{ route('profesor.solicitudes.index') }}"
               class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all border-t-4 border-cyan-500 flex flex-col items-center text-center">
                <div class="text-3xl mb-3">📄</div>
                <h3 class="text-lg font-bold text-gray-800">Mis Solicitudes</h3>
                <p class="text-gray-500 text-sm mt-2">Seguimiento al estatus de tus peticiones previas</p>
            </a>

            {{-- Reportar Fallas --}}
            <a href="{{ route('profesor.fallas.index') }}"
               class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all border-t-4 border-red-500 flex flex-col items-center text-center">
                <div class="text-3xl mb-3">⚠️</div>
                <h3 class="text-lg font-bold text-gray-800">Reportar Fallas</h3>
                <p class="text-gray-500 text-sm mt-2">Notificar y dar seguimiento a reportes técnicos</p>
            </a>

            {{-- Historial de Asistencias --}}
            <a href="{{ route('profesor.asistencias.index') }}"
               class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all border-t-4 border-orange-500 flex flex-col items-center text-center">
                <div class="text-3xl mb-3">📋</div>
                <h3 class="text-lg font-bold text-gray-800">Mis Asistencias</h3>
                <p class="text-gray-500 text-sm mt-2">Ver registro e historial de entradas en las instalaciones</p>
            </a>

        </div>

    </div>
</div>

</x-app-layout>