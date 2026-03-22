<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mis Incidencias
            </h2>
            
            <div class="flex gap-2">
                <!-- ➕ NUEVO -->
                <a href="{{ route('tecnico.incidencias.create') }}" 
                   class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition flex items-center gap-1">
                   <span>+</span> Nueva incidencia
                </a>

                <!-- 🔙 REGRESAR -->
                <a href="/tecnico"
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition flex items-center gap-1">
                   ⬅ Regresar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-700 uppercase text-xs font-medium">ID</th>
                        <th class="px-4 py-2 text-left text-gray-700 uppercase text-xs font-medium">Laboratorio</th>
                        <th class="px-4 py-2 text-left text-gray-700 uppercase text-xs font-medium">Descripción</th>
                        <th class="px-4 py-2 text-left text-gray-700 uppercase text-xs font-medium">Fecha y hora</th>
                        <th class="px-4 py-2 text-left text-gray-700 uppercase text-xs font-medium">Firma</th>
                        <th class="px-4 py-2 text-left text-gray-700 uppercase text-xs font-medium">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($incidencias as $inc)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2">{{ $inc->idincidencia }}</td>
                        <td class="px-4 py-2">{{ $inc->laboratorio->nombre ?? '-' }}</td>
                        <td class="px-4 py-2">{{ Str::limit($inc->descripcion, 50) }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($inc->fechahora)->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2">
                            @if($inc->firmadigital)
                                <img src="{{ $inc->firmadigital }}" alt="Firma" class="h-12 w-auto rounded border">
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 flex gap-2">
                            <a href="{{ route('tecnico.incidencias.show', $inc->idincidencia) }}" 
                               class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-sm">
                               Ver / Editar
                            </a>
                            @if(auth()->user()->can('delete', $inc))
                                <form action="{{ route('tecnico.incidencias.destroy', $inc->idincidencia) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition text-sm"
                                        onclick="return confirm('¿Seguro que desea eliminar esta incidencia?');">
                                        Eliminar
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-2 text-center text-gray-500">
                            No hay incidencias registradas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>