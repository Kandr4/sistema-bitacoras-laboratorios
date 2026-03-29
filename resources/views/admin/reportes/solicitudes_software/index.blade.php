<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <a href="{{ route('admin.reportes.index') }}" class="text-blue-500 hover:text-blue-700">Reportes</a> 
                <span class="text-gray-400">/</span> 
                <span>Sol. de Software</span>
            </h2>
            
            <div class="mt-4 md:mt-0 flex flex-wrap gap-2">
                <a href="{{ route('admin.reportes.software.exportar', array_merge(request()->all(), ['export_type' => 'pdf'])) }}" target="_blank"
                   class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded shadow text-sm font-bold flex items-center gap-2">
                   📄 PDF
                </a>
                <a href="{{ route('admin.reportes.software.exportar', array_merge(request()->all(), ['export_type' => 'excel'])) }}" 
                   class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded shadow text-sm font-bold flex items-center gap-2">
                   📊 Excel
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- BLOQUE DE FILTROS --}}
            <div class="bg-white p-6 rounded-lg shadow mb-6 border-t-4 border-blue-500">
                <form method="GET" action="{{ route('admin.reportes.software.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        
                        {{-- Fechas --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Desde</label>
                            <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Hasta</label>
                            <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        {{-- Docente --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Docente solicitante</label>
                            <select name="idusuario" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Todos</option>
                                @foreach($docentes as $docente)
                                    <option value="{{ $docente->id }}" {{ request('idusuario') == $docente->id ? 'selected' : '' }}>
                                        {{ trim($docente->nombre . ' ' . $docente->paterno) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Laboratorio --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Laboratorio</label>
                            <select name="idlab" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Todos</option>
                                @foreach($laboratorios as $lab)
                                    <option value="{{ $lab->idlab }}" {{ request('idlab') == $lab->idlab ? 'selected' : '' }}>
                                        {{ $lab->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Estado --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Estado de la solicitud</label>
                            <select name="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Todos</option>
                                @foreach($estados as $est)
                                    <option value="{{ $est }}" {{ request('estado') == $est ? 'selected' : '' }}>
                                        {{ ucfirst($est) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Botones Inferiores --}}
                        <div class="col-span-full border-t mt-2 pt-4 flex gap-2 justify-end">
                            <a href="{{ route('admin.reportes.software.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded shadow">Limpiar Filtros</a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded shadow font-bold">Aplicar Búsqueda</button>
                        </div>

                    </div>
                </form>
            </div>

            {{-- GRÁFICA PIE Y RESUMEN GENERAL --}}
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
                <div class="lg:col-span-3 bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold text-gray-800 mb-2 border-b pb-2">Distribución de Solicitudes (Por Estado)</h3>
                    {{-- PIE CHART CANVAS --}}
                    <div class="h-64 relative w-full flex justify-center mt-4">
                        <canvas id="softwarePieChart"></canvas>
                    </div>
                </div>
                <div class="bg-blue-600 text-white p-6 rounded-lg shadow flex flex-col justify-center items-center text-center">
                    <h3 class="text-xl font-bold mb-2">Total Solicitudes</h3>
                    <p class="text-6xl font-extrabold">{{ $solicitudes->count() }}</p>
                    <p class="mt-4 text-sm text-blue-200">Registros cumplen los parámetros de filtrado actuales.</p>
                </div>
            </div>

            {{-- TABLA DE RESULTADOS --}}
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-bold text-gray-600">Fecha</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600">Docente</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600">Software Solicitado</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600">Laboratorio</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600">Estado</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600">Observaciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($solicitudes as $sol)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap">{{ $sol->fecsolicitud ? date('d/m/Y', strtotime($sol->fecsolicitud)) : '' }}</td>
                                <td class="px-4 py-3 font-semibold text-gray-800">{{ $sol->usuario ? trim($sol->usuario->nombre . ' ' . $sol->usuario->paterno) : 'N/A' }}</td>
                                <td class="px-4 py-3 font-bold text-blue-800">{{ $sol->software }}</td>
                                <td class="px-4 py-3">{{ $sol->laboratorio ? $sol->laboratorio->nombre : 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    @if(strtolower($sol->estado) == 'pendiente')
                                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full font-bold">Pendiente</span>
                                    @elseif(strtolower($sol->estado) == 'atendida' || strtolower($sol->estado) == 'instalado')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full font-bold">Instalado</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-200 text-gray-800 text-xs rounded-full font-bold">{{ $sol->estado }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-xs text-gray-500 line-clamp-2 w-48">{{ $sol->comentario ?: '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">No se encontraron registros de software con los parámetros.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- Script de Chart.js PIE --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('softwarePieChart').getContext('2d');
            
            // Array global de colores de Tailwind para la pastel
            const colors = ['#3b82f6', '#10b981', '#ef4444', '#f59e0b', '#8b5cf6'];
            
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: {!! json_encode($graphData['labels']) !!},
                    datasets: [{
                        label: 'Cant. de Solicitudes',
                        data: {!! json_encode($graphData['values']) !!},
                        backgroundColor: colors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right' }
                    }
                }
            });
        });
    </script>
</x-app-layout>
