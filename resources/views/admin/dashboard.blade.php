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

            {{-- GRID DE MODULOS (Primero, estilos originales) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
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

                {{-- Asistencias --}}
                <a href="{{ route('admin.asistencias.index') }}" 
                   class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition border-l-4 border-orange-500">
                    <h3 class="text-lg font-semibold text-gray-800">📋 Asistencias</h3>
                    <p class="text-gray-500 text-sm mt-1">Gestión de asistencias de profesores</p>
                </a>
            </div>

            <hr class="mb-8 border-gray-200">

            {{-- HEADER DE ESTADISTICAS Y BOTON PDF --}}
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">
                        Resumen Operativo
                    </h2>
                </div>
                
                <a href="{{ route('admin.dashboard.pdf') }}" target="_blank"
                   class="mt-4 sm:mt-0 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow text-sm font-medium transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Exportar a PDF
                </a>
            </div>

            {{-- SECCION ESTADISTICAS Y GRAFICA JUNTAS --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10 items-start">
                
                {{-- Tarjetas (Izquierda, más pequeñas) --}}
                <div class="lg:col-span-2">
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <!-- Asistencias -->
                        <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-orange-500">
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wide mb-1">Asistencias</p>
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['asistencias']) }}</p>
                        </div>
                        
                        <!-- Fallas -->
                        <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-red-500">
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wide mb-1">Fallas Status</p>
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['fallas']) }}</p>
                        </div>

                        <!-- Solicitudes SW -->
                        <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-indigo-500">
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wide mb-1">Sol. Software</p>
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['solicitudesSoftware']) }}</p>
                        </div>

                        <!-- Reparaciones -->
                        <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-green-500">
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wide mb-1">Mant. Realizados</p>
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['reparaciones']) }}</p>
                        </div>

                        <!-- Compras -->
                        <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-blue-400">
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wide mb-1">Sol. Compra</p>
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['compras']) }}</p>
                        </div>
                    </div>
                </div>

                {{-- Gráfica (Derecha) --}}
                <div class="bg-white p-5 rounded-lg shadow-sm lg:col-span-1">
                    <h3 class="text-sm font-bold text-gray-700 mb-3 border-b pb-2">Proporción de Registros</h3>
                    <div class="relative w-full h-48 flex justify-center">
                        <canvas id="dashboardChart"></canvas>
                    </div>
                </div>

            </div>

        </div>
    </div>

    {{-- Script de Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('dashboardChart').getContext('2d');
            
            // Colores correspondientes a Tailwind (Orange, Red, Indigo, Blue)
            const colores = ['#f97316', '#ef4444', '#6366f1', '#60a5fa'];
            
            const data = {
                labels: [
                    'Asistencias', 
                    'Fallas', 
                    'Sol. Software', 
                    'Sol. Compra'
                ],
                datasets: [{
                    label: 'Registros',
                    data: [
                        {{ $stats['asistencias'] }}, 
                        {{ $stats['fallas'] }}, 
                        {{ $stats['solicitudesSoftware'] }}, 
                        {{ $stats['compras'] }}
                    ],
                    backgroundColor: colores,
                    borderWidth: 1
                }]
            };

            const config = {
                type: 'pie', // Gráfica circular simple
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            };

            new Chart(ctx, config);
        });
    </script>
</x-app-layout>