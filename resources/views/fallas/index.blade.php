<x-app-layout>
    <x-slot name="header">
         <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gestión de Fallas
            </h2>
            <div class="flex gap-2">
                <!-- ➕ NUEVO -->
                <a   <a href="{{ route('fallas.create') }}"
                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                + Nuevo
                </a>

                <!-- 🔙 REGRESAR -->
                <a  href="/tecnico"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                ⬅ Regresar
                </a>
            </div>
         </div>

            
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto space-y-6">

        {{-- 🔍 FILTROS --}}
        <form method="GET" class="bg-white p-6 rounded-lg shadow space-y-4">
            <h3 class="text-lg font-semibold text-gray-700">Filtrar fallas</h3>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                {{-- Laboratorio --}}
                <div>
                    <label class="block text-gray-600 font-medium mb-1">Laboratorio</label>
                    <select name="laboratorio_id"
                        class="w-full border rounded px-3 py-2 focus:ring-1 focus:ring-blue-500">
                        <option value="">Todos</option>
                        @foreach($laboratorios as $lab)
                            <option value="{{ $lab->idlab }}"
                                {{ request('laboratorio_id') == $lab->idlab ? 'selected' : '' }}>
                                {{ $lab->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Usuario --}}
                <div>
                    <label class="block text-gray-600 font-medium mb-1">Usuario</label>
                    <select name="usuario_id"
                        class="w-full border rounded px-3 py-2 focus:ring-1 focus:ring-blue-500">
                        <option value="">Todos</option>
                        @foreach($usuarios as $user)
                            <option value="{{ $user->id }}"
                                {{ request('usuario_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->nombre }} ({{ $user->rol }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tipo --}}
                <div>
                    <label class="block text-gray-600 font-medium mb-1">Tipo</label>
                    <select name="tipo_falla"
                        class="w-full border rounded px-3 py-2 focus:ring-1 focus:ring-blue-500">
                        <option value="">Todos</option>
                        <option value="hardware" {{ request('tipo_falla') == 'hardware' ? 'selected' : '' }}>Hardware</option>
                        <option value="software" {{ request('tipo_falla') == 'software' ? 'selected' : '' }}>Software</option>
                        <option value="red" {{ request('tipo_falla') == 'red' ? 'selected' : '' }}>Red</option>
                        <option value="perifericos" {{ request('tipo_falla') == 'perifericos' ? 'selected' : '' }}>Periféricos</option>
                        <option value="otros" {{ request('tipo_falla') == 'otros' ? 'selected' : '' }}>Otros</option>
                    </select>
                </div>

                {{-- Estado --}}
                <div>
                    <label class="block text-gray-600 font-medium mb-1">Estado</label>
                    <select name="estado"
                        class="w-full border rounded px-3 py-2 focus:ring-1 focus:ring-blue-500">
                        <option value="">Todos</option>
                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="en revision" {{ request('estado') == 'en revision' ? 'selected' : '' }}>En revisión</option>
                        <option value="resuelto" {{ request('estado') == 'resuelto' ? 'selected' : '' }}>Resuelto</option>
                    </select>
                </div>

            </div>

            {{-- Botones --}}
            <div class="flex justify-between mt-4">
                <div class="flex gap-2">
                    <a href="{{ route('fallas.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Limpiar
                    </a>
            
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Filtrar
                        </button>
                </div>
            </div>
        </form>

        {{-- 📋 TABLA --}}
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">
                    <tr class="text-left text-sm font-semibold text-gray-700">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Fecha</th>
                        <th class="px-4 py-2">Laboratorio</th>
                        <th class="px-4 py-2">Equipo</th>
                        <th class="px-4 py-2">Usuario</th>
                        <th class="px-4 py-2">Tipo</th>
                        <th class="px-4 py-2">Estado</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @foreach($fallas as $falla)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm">{{ $falla->id }}</td>
                            <td class="px-4 py-2 text-sm">{{ $falla->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-2 text-sm">{{ $falla->laboratorio->nombre ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $falla->equipo->nombre ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $falla->usuario->nombre ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm capitalize">{{ $falla->tipo_falla }}</td>

                            {{-- Estado con color --}}
                            <td class="px-4 py-2 text-sm">
                                <span class="px-2 py-1 text-xs text-white rounded
                                    @if($falla->estado == 'pendiente') bg-yellow-500
                                    @elseif($falla->estado == 'en revision') bg-blue-500
                                    @elseif($falla->estado == 'resuelto') bg-green-500
                                    @endif">
                                    {{ ucfirst($falla->estado) }}
                                </span>
                            </td>

                            {{-- Acciones --}}
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ route('fallas.edit', $falla) }}"
                                   class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                                    Editar
                                </a>

                                @if(auth()->user()->rol === 'Técnico')
                                    <form action="{{ route('fallas.destroy', $falla) }}" method="POST"
                                        onsubmit="return confirm('¿Seguro que deseas eliminar esta falla?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm shadow">
                                            Eliminar
                                        </button>
                                    </form>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Paginación --}}
            <div class="p-4">
                {{ $fallas->withQueryString()->links() }}
            </div>
        </div>

    </div>
</x-app-layout>