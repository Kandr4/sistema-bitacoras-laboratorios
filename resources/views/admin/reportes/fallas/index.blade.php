<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <a href="{{ route('admin.reportes.index') }}" class="text-blue-500 hover:text-blue-700">Reportes</a> 
                <span class="text-gray-400">/</span> 
                <span>Fallas</span>
            </h2>
            
            <div class="mt-4 md:mt-0 flex flex-wrap gap-2">
                <a href="{{ route('admin.reportes.fallas.exportar', array_merge(request()->all(), ['export_type' => 'pdf'])) }}" target="_blank"
                   class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded shadow text-sm font-bold flex items-center gap-2">
                   📄 PDF
                </a>
                <a href="{{ route('admin.reportes.fallas.exportar', array_merge(request()->all(), ['export_type' => 'excel'])) }}" 
                   class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded shadow text-sm font-bold flex items-center gap-2">
                   📊 Excel
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- BLOQUE DE FILTROS --}}
            <div class="bg-white p-6 rounded-lg shadow mb-6 border-t-4 border-red-500">
                <form method="GET" action="{{ route('admin.reportes.fallas.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        
                        {{-- Fechas --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Desde</label>
                            <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Hasta</label>
                            <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                        </div>

                        {{-- Usuario Reportante --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Reportante</label>
                            <select name="usuario_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                                <option value="">Todos</option>
                                @foreach($usuarios as $user)
                                    <option value="{{ $user->id }}" {{ request('usuario_id') == $user->id ? 'selected' : '' }}>
                                        {{ trim($user->nombre . ' ' . $user->paterno) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Laboratorio --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Laboratorio</label>
                            <select name="laboratorio_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                                <option value="">Todos</option>
                                @foreach($laboratorios as $lab)
                                    <option value="{{ $lab->idlab }}" {{ request('laboratorio_id') == $lab->idlab ? 'selected' : '' }}>
                                        {{ $lab->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        {{-- Equipo --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Equipo</label>
                            <select name="equipo_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                                <option value="">Todos</option>
                                @foreach($equipos as $eq)
                                    <option value="{{ $eq->id }}" {{ request('equipo_id') == $eq->id ? 'selected' : '' }}>
                                        {{ $eq->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tipo de Falla --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tipo de Falla</label>
                            <select name="tipo_falla" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                                <option value="">Todos</option>
                                @foreach($tipos_falla as $tf)
                                    <option value="{{ $tf }}" {{ request('tipo_falla') == $tf ? 'selected' : '' }}>
                                        {{ ucfirst($tf) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Estado --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Estado</label>
                            <select name="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                                <option value="">Todos</option>
                                <option value="Pendiente" {{ request('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="Atendida" {{ request('estado') == 'Atendida' ? 'selected' : '' }}>Atendida</option>
                                <option value="En progreso" {{ request('estado') == 'En progreso' ? 'selected' : '' }}>En progreso</option>
                            </select>
                        </div>

                        {{-- Comportamiento de Gráfica --}}
                        <div class="col-span-full border-t mt-2 pt-2 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="w-full sm:w-1/3">
                                <label class="block text-sm font-bold text-gray-700">Agrupar Gráfica por:</label>
                                <select name="agrupar_por" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500" onchange="this.form.submit()">
                                    <option value="laboratorio" {{ request('agrupar_por') == 'laboratorio' ? 'selected' : '' }}>Laboratorio</option>
                                    <option value="tipo_falla" {{ request('agrupar_por') == 'tipo_falla' ? 'selected' : '' }}>Tipo de Falla</option>
                                </select>
                            </div>
                            
                            <div class="flex gap-2">
                                <a href="{{ route('admin.reportes.fallas.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded shadow">Limpiar Filtros</a>
                                <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded shadow font-bold">Aplicar Búsqueda</button>
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
                        <canvas id="fallasChart"></canvas>
                    </div>
                </div>
                <div class="bg-red-600 text-white p-6 rounded-lg shadow flex flex-col justify-center items-center text-center">
                    <h3 class="text-xl font-bold mb-2">Total de Fallas</h3>
                    <p class="text-6xl font-extrabold">{{ $fallas->count() }}</p>
                    <p class="mt-4 text-sm text-red-200">Registros cumplen los parámetros de filtrado.</p>
                </div>
            </div>

            {{-- TABLA DE RESULTADOS --}}
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-bold text-gray-600">Fecha</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600">Equipo</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600">Laboratorio</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600">Descripción & Tipo</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600">Estado</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-600">Reportante</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($fallas as $falla)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap">{{ $falla->created_at ? $falla->created_at->format('d/m/Y H:i') : '' }}</td>
                                <td class="px-4 py-3 font-semibold text-gray-800">{{ $falla->equipo ? $falla->equipo->nombre : 'N/A' }}</td>
                                <td class="px-4 py-3">{{ $falla->laboratorio ? $falla->laboratorio->nombre : 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-block px-2 py-1 bg-gray-200 text-xs rounded-full font-bold mb-1">{{ $falla->tipo_falla }}</span>
                                    <p class="text-xs text-gray-500 line-clamp-2 w-48">{{ $falla->descripcion }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    @if(strtolower($falla->estado) == 'pendiente')
                                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full font-bold">Pendiente</span>
                                    @elseif(strtolower($falla->estado) == 'atendida')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full font-bold">Atendida</span>
                                    @else
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full font-bold">{{ $falla->estado }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-xs">{{ $falla->usuario ? trim($falla->usuario->nombre . ' ' . $falla->usuario->paterno) : 'N/A' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">No se encontraron registros con los filtros actuales.</td>
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
            const ctx = document.getElementById('fallasChart').getContext('2d');
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($graphData['labels']) !!},
                    datasets: [{
                        label: 'Número de Fallas',
                        data: {!! json_encode($graphData['values']) !!},
                        backgroundColor: '#dc2626', // Red 600
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
