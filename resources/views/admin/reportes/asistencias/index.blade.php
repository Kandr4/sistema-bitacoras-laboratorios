<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <a href="{{ route('admin.reportes.index') }}" class="text-blue-500 hover:text-blue-700">Reportes</a> 
                <span class="text-gray-400">/</span> 
                <span>Asistencias</span>
            </h2>
            
            <div class="mt-4 md:mt-0 flex flex-wrap gap-2">
                {{-- Los botones apuntan a exportar pasandole todo el Query String actual del request --}}
                <a href="{{ route('admin.reportes.asistencias.exportar', array_merge(request()->all(), ['export_type' => 'pdf'])) }}" target="_blank"
                   class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded shadow text-sm font-bold flex items-center gap-2">
                   📄 PDF
                </a>
                <a href="{{ route('admin.reportes.asistencias.exportar', array_merge(request()->all(), ['export_type' => 'excel'])) }}" 
                   class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded shadow text-sm font-bold flex items-center gap-2">
                   📊 Excel
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- BLOQUE DE FILTROS --}}
            <div class="bg-white p-6 rounded-lg shadow mb-6 border-t-4 border-indigo-500">
                <form method="GET" action="{{ route('admin.reportes.asistencias.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        
                        {{-- Fechas --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Desde</label>
                            <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Hasta</label>
                            <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        {{-- Docente --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Docente</label>
                            <select name="idusuario" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Todos</option>
                                @foreach($docentes as $docente)
                                    <option value="{{ $docente->id }}" {{ request('idusuario') == $docente->id ? 'selected' : '' }}>
                                        {{ $docente->nombre }} {{ $docente->paterno }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Laboratorio --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Laboratorio</label>
                            <select name="idlaboratorio" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Todos</option>
                                @foreach($laboratorios as $lab)
                                    <option value="{{ $lab->idlab }}" {{ request('idlaboratorio') == $lab->idlab ? 'selected' : '' }}>
                                        {{ $lab->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        {{-- Atributos de Práctica --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Asignatura</label>
                            <input type="text" name="asignatura" value="{{ request('asignatura') }}" placeholder="Ej. Redes"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Carrera</label>
                            <input type="text" name="carrera" value="{{ request('carrera') }}" placeholder="Ej. Ingeniería"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cuatrimestre</label>
                            <input type="text" name="cuatrimestre" value="{{ request('cuatrimestre') }}" placeholder="Ej. 1er"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Grupo</label>
                            <input type="text" name="grupo" value="{{ request('grupo') }}" placeholder="Ej. A"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        {{-- Comportamiento de Gráfica --}}
                        <div class="col-span-full border-t mt-2 pt-2 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="w-full sm:w-1/3">
                                <label class="block text-sm font-bold text-gray-700">Agrupar Gráfica por:</label>
                                <select name="agrupar_por" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="this.form.submit()">
                                    <option value="laboratorio" {{ request('agrupar_por') == 'laboratorio' ? 'selected' : '' }}>Laboratorio</option>
                                    <option value="docente" {{ request('agrupar_por') == 'docente' ? 'selected' : '' }}>Docente</option>
                                </select>
                            </div>
                            
                            <div class="flex gap-2">
                                <a href="{{ route('admin.reportes.asistencias.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded shadow">Limpiar Filtros</a>
                                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded shadow font-bold">Aplicar Búsqueda</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            {{-- GRÁFICA Y RESUMEN GENERAL --}}
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
                <div class="lg:col-span-3 bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $graphData['title'] }}</h3>
                    <div class="h-64 relative w-full">
                        <canvas id="asistenciasChart"></canvas>
                    </div>
                </div>
                <div class="bg-indigo-600 text-white p-6 rounded-lg shadow flex flex-col justify-center items-center text-center">
                    <h3 class="text-xl font-bold mb-2">Total Resultante</h3>
                    <p class="text-6xl font-extrabold">{{ $asistencias->count() }}</p>
                    <p class="mt-4 text-sm text-indigo-200">Registros cumplen los parámetros de filtrado.</p>
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
                                <th class="px-4 py-3 text-left font-bold text-gray-600">Laboratorio</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600">C/G/A</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600">Entrada</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600">Salida</th>
                                <th class="px-4 py-3 text-left font-bold text-indigo-600">Permanencia</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($asistencias as $asistencia)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap">{{ $asistencia->fecha ? $asistencia->fecha->format('d/m/Y') : '' }}</td>
                                <td class="px-4 py-3">{{ $asistencia->usuario ? trim($asistencia->usuario->nombre . ' ' . $asistencia->usuario->paterno) : 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $asistencia->laboratorio ? $asistencia->laboratorio->nombre : 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    <div class="text-xs text-gray-500">
                                        <span class="font-bold">C:</span> {{ $asistencia->carrera ?: '-' }} <br>
                                        <span class="font-bold">G:</span> {{ $asistencia->cuatrimestre ?: '-' }}{{ $asistencia->grupo ?: '-' }} <br>
                                        <span class="font-bold">A:</span> {{ $asistencia->asignatura ?: '-' }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">{{ $asistencia->entrada ? $asistencia->entrada->format('H:i') : '' }}</td>
                                <td class="px-4 py-3">{{ $asistencia->salida ? $asistencia->salida->format('H:i') : 'En curso' }}</td>
                                <td class="px-4 py-3 font-bold text-indigo-700">{{ $asistencia->permanencia_calc }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-500">No se encontraron registros con los filtros actuales.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- Script de Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('asistenciasChart').getContext('2d');
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($graphData['labels']) !!},
                    datasets: [{
                        label: 'Número de Asistencias',
                        data: {!! json_encode($graphData['values']) !!},
                        backgroundColor: '#4f46e5',
                        borderRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 } }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        });
    </script>
</x-app-layout>
