<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="text-blue-500 hover:text-blue-700">Panel Admin</a> 
            <span class="text-gray-400">/</span> 
            <span>Central de Reportes</span>
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Módulo de Reportes</h1>
                <p class="text-gray-600 mt-2">Selecciona la categoría del reporte que deseas consultar y exportar.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                {{-- Reporte de Asistencias --}}
                <a href="{{ route('admin.reportes.asistencias.index') }}" 
                   class="block bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="h-2 bg-indigo-600"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-gray-800">📋 Asistencias</h3>
                            <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">
                            Filtra asistencias por fecha, docente, laboratorio y características académicas. Exportable en PDF/Excel.
                        </p>
                    </div>
                </a>

                {{-- Reporte de Fallas --}}
                <a href="{{ route('admin.reportes.fallas.index') }}" 
                   class="block bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="h-2 bg-red-600"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-gray-800">⚠️ Fallas</h3>
                            <div class="p-2 bg-red-100 rounded-lg text-red-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">
                            Filtra el historial de incidencias técnicas en los equipos y laboratorios. Exportable en PDF/Excel.
                        </p>
                    </div>
                </a>

                {{-- Reporte de Solicitudes SW --}}
                <a href="{{ route('admin.reportes.software.index') }}" 
                   class="block bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="h-2 bg-blue-600"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-gray-800">💻 Software</h3>
                            <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">
                            Filtra las solicitudes de programas y visualiza el balance de atención (Gráfica circular).
                        </p>
                    </div>
                </a>

            </div>

        </div>
    </div>
</x-app-layout>
