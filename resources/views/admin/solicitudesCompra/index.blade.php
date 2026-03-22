<x-app-layout>
    <x-slot name="header">
         <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Solicitudes de Compra - Administrador
            </h2>
            <a href="/admin"
               class="bg-gray-500 text-white px-4 py-2 rounded-lg">
               ⬅ Regresar
            </a>
         </div>
        
    </x-slot>

    <div class="py-4">
        {{-- Filtros --}}
        <form method="GET" action="{{ route('admin.solicitudesCompra.index') }}" class="mb-4 flex flex-wrap gap-2 items-center">
            <select name="estado" class="border rounded px-4.5 py-2 shadow-sm focus:ring-1 focus:ring-blue-500">
                <option value="">Todos los estados</option>
                <option value="autorizada" {{ request('estado') == 'autorizada' ? 'selected' : '' }}>Autorizada</option>
                <option value="rechazada" {{ request('estado') == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
            </select>

            <select name="laboratorio_id" class="border rounded px-4.5 py-2 shadow-sm focus:ring-1 focus:ring-blue-500">
                <option value="">Todos los laboratorios</option>
                @foreach($laboratorios as $lab)
                    <option value="{{ $lab->idlab }}" {{ request('laboratorio_id') == $lab->idlab ? 'selected' : '' }}>{{ $lab->nombre }}</option>
                @endforeach
            </select>

            <select name="tecnico_id" class="border rounded px-4.5 py-2 shadow-sm focus:ring-1 focus:ring-blue-500">
                <option value="">Todos los técnicos</option>
                @foreach($tecnicos as $tec)
                    <option value="{{ $tec->id }}" {{ request('tecnico_id') == $tec->id ? 'selected' : '' }}>{{ $tec->nombre }}</option>
                @endforeach
            </select>

            <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" class="border rounded px-1 py-2 shadow-sm focus:ring-1 focus:ring-blue-500">
            <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" class="border rounded px-1 py-2 shadow-sm focus:ring-1 focus:ring-blue-500">

            <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700 transition">Filtrar</button>

            {{-- Botón Limpiar --}}
            <a href="{{ route('admin.solicitudesCompra.index') }}"
            class="px-3 py-2 bg-gray-300 text-gray-700 rounded shadow hover:bg-gray-400 transition">
            Limpiar
            </a>
        
        </form>

        {{-- Tabla --}}
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr class="text-left text-gray-600 uppercase text-sm font-semibold">
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Laboratorio</th>
                        <th class="px-4 py-3">Creador</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3">Validado Por</th>
                        <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($solicitudes as $sol)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $sol->id }}</td>
                        <td class="px-4 py-2">{{ $sol->laboratorio->nombre ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $sol->tecnico ? $sol->tecnico->nombre . ' ' . $sol->tecnico->paterno : '-' }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @if($sol->estado == 'autorizada') bg-green-100 text-green-800
                                @elseif($sol->estado == 'rechazada') bg-red-100 text-red-800
                                @elseif($sol->estado == 'en proceso') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($sol->estado) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $sol->admin ? $sol->admin->nombre : '-' }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.solicitudesCompra.show', $sol->id) }}"
                            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm transition shadow">
                            Ver / Actualizar
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-2 text-center text-gray-500">No hay solicitudes</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>