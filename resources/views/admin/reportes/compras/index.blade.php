<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <a href="{{ route('admin.reportes.index') }}" class="text-emerald-500 hover:text-emerald-700">Reportes</a> 
                <span class="text-gray-400">/</span> 
                <span>Sol. de Compras</span>
            </h2>
            
            <div class="mt-4 md:mt-0 flex flex-wrap gap-2">
                <a href="{{ route('admin.reportes.compras.exportar', array_merge(request()->all(), ['export_type' => 'pdf'])) }}" target="_blank"
                   class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded shadow text-sm font-bold flex items-center gap-2">
                   📄 PDF
                </a>
                <a href="{{ route('admin.reportes.compras.exportar', array_merge(request()->all(), ['export_type' => 'excel'])) }}" 
                   class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded shadow text-sm font-bold flex items-center gap-2">
                   📊 Excel
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- BLOQUE DE FILTROS --}}
            <div class="bg-white p-6 rounded-lg shadow mb-6 border-t-4 border-emerald-500">
                <form method="GET" action="{{ route('admin.reportes.compras.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        
                        {{-- Fechas --}}
                        <div class="col-span-1 md:col-span-2 grid grid-cols-2 gap-2 border p-3 rounded-lg bg-gray-50 border-gray-200">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">📆 Fecha Desde</label>
                                <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">📆 Hasta</label>
                                <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                            </div>
                        </div>

                        {{-- Rango de Costos --}}
                        <div class="col-span-1 md:col-span-2 grid grid-cols-2 gap-2 border p-3 rounded-lg bg-gray-50 border-gray-200">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">💲 Costo Min.</label>
                                <input type="number" step="0.01" min="0" name="costo_min" value="{{ request('costo_min') }}" placeholder="Ej. 100"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">💲 Costo Máx.</label>
                                <input type="number" step="0.01" min="0" name="costo_max" value="{{ request('costo_max') }}" placeholder="Ej. 5000"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                            </div>
                        </div>

                        {{-- Técnico --}}
                        <div class="col-span-1 md:col-span-2 lg:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Técnico solicitante</label>
                            <select name="idusuario" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                                <option value="">Todos</option>
                                @foreach($tecnicos as $tecnico)
                                    <option value="{{ $tecnico->id }}" {{ request('idusuario') == $tecnico->id ? 'selected' : '' }}>
                                        {{ trim($tecnico->nombre . ' ' . $tecnico->paterno) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Laboratorio --}}
                        <div class="col-span-1 md:col-span-2 lg:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Laboratorio Destino</label>
                            <select name="idlab" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                                <option value="">Todos</option>
                                @foreach($laboratorios as $lab)
                                    <option value="{{ $lab->idlab }}" {{ request('idlab') == $lab->idlab ? 'selected' : '' }}>
                                        {{ $lab->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Estado --}}
                        <div class="col-span-1 lg:col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Estado Resolutivo</label>
                            <select name="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                                <option value="">Todos</option>
                                @foreach($estados as $est)
                                    <option value="{{ $est }}" {{ request('estado') == $est ? 'selected' : '' }}>
                                        {{ ucfirst($est) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Botones Inferiores --}}
                        <div class="col-span-full border-t mt-3 pt-4 flex gap-2 justify-end">
                            <a href="{{ route('admin.reportes.compras.index') }}" class="px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded shadow font-medium">Limpiar Todo</a>
                            <button type="submit" class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded shadow font-bold">Aplicar Búsqueda</button>
                        </div>

                    </div>
                </form>
            </div>

            {{-- GRÁFICA PIE Y RESUMEN GENERAL --}}
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
                <div class="lg:col-span-3 bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold text-gray-800 mb-2 border-b pb-2">Distribución de Estados sobre Volumen de Compras</h3>
                    {{-- PIE CHART CANVAS --}}
                    <div class="h-64 relative w-full flex justify-center mt-4">
                        <canvas id="comprasPieChart"></canvas>
                    </div>
                </div>
                <div class="bg-emerald-600 text-white p-6 rounded-lg shadow flex flex-col justify-center items-center text-center">
                    <h3 class="text-xl font-bold mb-2 text-emerald-100">Total Financiero (Estimado)</h3>
                    {{-- Aqui mostramos la sumatoria financiera real del grupo filtrado --}}
                    <p class="text-4xl font-extrabold mb-1">${{ number_format($compras->sum('costo_unitario'), 2) }}</p>
                    <p class="mt-4 text-xs font-bold bg-white text-emerald-800 px-3 py-1 rounded-full">{{ $compras->count() }} Peticiones Listadas</p>
                </div>
            </div>

            {{-- TABLA DE RESULTADOS --}}
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-3 text-left font-bold text-gray-600">Fecha</th>
                                <th class="px-3 py-3 text-left font-bold text-gray-600">Técnico</th>
                                <th class="px-3 py-3 text-left font-bold text-gray-600">Requerimiento</th>
                                <th class="px-3 py-3 text-left font-bold text-gray-600">Costo U.</th>
                                <th class="px-3 py-3 text-left font-bold text-gray-600">Estado</th>
                                <th class="px-3 py-3 text-left font-bold text-gray-600">Justificación</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($compras as $com)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-3 whitespace-nowrap">{{ $com->fecha_solicitud ? date('d/m/Y', strtotime($com->fecha_solicitud)) : '' }}</td>
                                <td class="px-3 py-3 font-semibold text-gray-800">{{ $com->tecnico ? trim($com->tecnico->nombre . ' ' . $com->tecnico->paterno) : 'N/A' }}</td>
                                <td class="px-3 py-3">
                                    <div class="font-bold text-emerald-800">{{ $com->cantidad }}x - {{ $com->descripcion }}</div>
                                    <div class="text-xs text-gray-500 line-clamp-1 w-32" title="{{ $com->caracteristicas }}">{{ $com->caracteristicas }}</div>
                                </td>
                                <td class="px-3 py-3 font-bold text-gray-700">${{ number_format($com->costo_unitario, 2) }}</td>
                                <td class="px-3 py-3">
                                    @if(strtolower($com->estado) == 'pendiente')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full font-bold">Pendiente</span>
                                    @elseif(strtolower($com->estado) == 'aprobada' || strtolower($com->estado) == 'aprobado' || strtolower($com->estado) == 'comprado')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full font-bold">Aprobado</span>
                                    @elseif(strtolower($com->estado) == 'rechazada' || strtolower($com->estado) == 'cancelada')
                                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full font-bold">Rechazada</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-200 text-gray-800 text-xs rounded-full font-bold">{{ $com->estado }}</span>
                                    @endif
                                </td>
                                <td class="px-3 py-3 text-xs text-gray-500 line-clamp-2 w-48">{{ $com->justificacion ?: '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center font-medium text-gray-500">No se localizaron ordenes de compra con los filtros declarados.</td>
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
            const ctx = document.getElementById('comprasPieChart').getContext('2d');
            
            // Array global de colores de Tailwind para la pastel contable (Tonos sobrios/financieros)
            const colors = ['#10b981', '#f59e0b', '#ef4444', '#6366f1', '#8b5cf6'];
            
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: {!! json_encode($graphData['labels']) !!},
                    datasets: [{
                        label: 'Número de Compras',
                        data: {!! json_encode($graphData['values']) !!},
                        backgroundColor: colors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right' },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) { label += ': '; }
                                    if (context.parsed !== null) { label += context.parsed + " Solicitudes"; }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
