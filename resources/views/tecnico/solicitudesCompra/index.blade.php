<x-app-layout>
    <x-slot name="header">
         <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Solicitudes de Compra
            </h2>
            <div class="flex gap-2">
                <!-- ➕ NUEVO -->
                <a  href="{{ route('tecnico.solicitudesCompra.create') }}" 
                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                + Nuevo
                </a>

                <!-- 🔙 REGRESAR -->
                <a href="/tecnico"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                ⬅ Regresar
                </a>
            </div>
         </div>
    </x-slot>

    <div class="py-4">
        {{-- Formulario de filtros --}}
        <form method="GET" action="{{ route('tecnico.solicitudesCompra.index') }}" class="mb-4 flex flex-wrap gap-4 items-end">

            {{-- Laboratorio --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Laboratorio</label>
                <select name="laboratorio_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Todos</option>
                    @foreach($laboratorios as $lab)
                        <option value="{{ $lab->idlab }}" {{ request('laboratorio_id') == $lab->idlab ? 'selected' : '' }}>
                            {{ $lab->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Estado --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Estado</label>
                <select name="estado" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Todos</option>
                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="aprobado" {{ request('estado') == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                    <option value="rechazado" {{ request('estado') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                </select>
            </div>

            {{-- Rango de fechas --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Fecha desde</label>
                <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Fecha hasta</label>
                <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Filtrar
                </button>
                <a href="{{ route('tecnico.solicitudesCompra.index') }}"
                    class="ml-2 px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">
                    Limpiar
                </a>
            </div>
        </form>

        {{-- Tabla con scroll horizontal --}}
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            @if(count(request()->query()) > 0)
                <div class="mb-2 text-gray-600">
                    Filtrando por:
                    @if(request('estado')) Estado = {{ request('estado') }} @endif
                    @if(request('laboratorio_id')) Laboratorio = {{ \App\Models\Laboratorio::find(request('laboratorio_id'))->nombre }} @endif
                    @if(request('fecha_desde')) Desde = {{ request('fecha_desde') }} @endif
                    @if(request('fecha_hasta')) Hasta = {{ request('fecha_hasta') }} @endif
                </div>
            @endif

            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2 text-left">ID</th>
                        <th class="border px-4 py-2 text-left">Laboratorio</th>
                        <th class="border px-4 py-2 text-left">Cantidad</th>
                        <th class="border px-4 py-2 text-left">Descripción</th>
                        <th class="border px-4 py-2 text-left">Características</th>
                        <th class="border px-4 py-2 text-left">Costo Unitario</th>
                        <th class="border px-4 py-2 text-left">Justificación</th>
                        <th class="border px-4 py-2 text-left">Estado</th>
                        <th class="border px-4 py-2 text-left">Fecha</th>
                        <th class="border px-4 py-2 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($solicitudes as $sol)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2">{{ $sol->id }}</td>
                            <td class="border px-4 py-2">{{ $sol->laboratorio->nombre }}</td>
                            <td class="border px-4 py-2">{{ $sol->cantidad }}</td>
                            <td class="border px-4 py-2">{{ $sol->descripcion }}</td>
                            <td class="border px-4 py-2">{{ $sol->caracteristicas }}</td>
                            <td class="border px-4 py-2">${{ number_format($sol->costo_unitario, 2) }}</td>
                            <td class="border px-4 py-2">{{ $sol->justificacion }}</td>
                            <td class="border px-4 py-2">{{ ucfirst($sol->estado) }}</td>
                            <td class="border px-4 py-2">{{ $sol->created_at->format('d/m/Y') }}</td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('tecnico.solicitudesCompra.show', $sol->id) }}"
                                   class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm transition">
                                   Ver
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="border px-4 py-2 text-center">No hay solicitudes registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>