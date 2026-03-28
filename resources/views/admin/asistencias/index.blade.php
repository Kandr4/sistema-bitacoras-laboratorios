<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📋 Gestión de Asistencias
            </h2>
            <a href="/admin"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition flex items-center gap-1">
                ⬅ Regresar
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Mensaje de éxito --}}
        @if(session('success'))
            <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- Filtros --}}
        <form method="GET" class="bg-white p-6 rounded-lg shadow space-y-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Filtrar asistencias</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                {{-- Fecha inicio --}}
                <div class="flex flex-col">
                    <label class="text-gray-600 font-medium mb-1">Fecha inicio</label>
                    <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}"
                           class="border rounded px-3 py-2 w-full focus:ring-1 focus:ring-blue-500">
                </div>

                {{-- Fecha fin --}}
                <div class="flex flex-col">
                    <label class="text-gray-600 font-medium mb-1">Fecha fin</label>
                    <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}"
                           class="border rounded px-3 py-2 w-full focus:ring-1 focus:ring-blue-500">
                </div>

                {{-- Docente (autocomplete) --}}
                <div x-data="autocomplete()" class="flex flex-col relative">
                    <label class="text-gray-600 font-medium mb-1">Docente</label>
                    <input type="text"
                        x-model="query"
                        @input="search()"
                        placeholder="Buscar docente..."
                        class="border rounded px-3 py-2 w-full focus:ring-1 focus:ring-blue-500">

                    <input type="hidden" name="idusuario" x-model="selectedId">

                    <ul x-show="results.length > 0"
                        class="absolute z-10 bg-white border rounded w-full mt-1 max-h-60 overflow-auto shadow"
                        style="top: 100%;">
                        <template x-for="user in results" :key="user.id">
                            <li @click="select(user)"
                                class="px-3 py-2 cursor-pointer hover:bg-blue-100"
                                x-text="user.nombre + ' ' + user.paterno"></li>
                        </template>
                    </ul>
                </div>

                {{-- Laboratorio --}}
                <div class="flex flex-col">
                    <label class="text-gray-600 font-medium mb-1">Laboratorio</label>
                    <select name="idlaboratorio" class="border rounded px-3 py-2 w-full focus:ring-1 focus:ring-blue-500">
                        <option value="">Todos</option>
                        @foreach($laboratorios as $lab)
                            <option value="{{ $lab->idlab }}" {{ request('idlaboratorio') == $lab->idlab ? 'selected' : '' }}>
                                {{ $lab->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Asignatura --}}
                <div class="flex flex-col">
                    <label class="text-gray-600 font-medium mb-1">Asignatura</label>
                    <select name="asignatura" class="border rounded px-3 py-2 w-full focus:ring-1 focus:ring-blue-500">
                        <option value="">Todas</option>
                        @foreach($asignaturas as $asig)
                            <option value="{{ $asig }}" {{ request('asignatura') == $asig ? 'selected' : '' }}>
                                {{ $asig }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Grupo --}}
                <div class="flex flex-col">
                    <label class="text-gray-600 font-medium mb-1">Grupo</label>
                    <select name="grupo" class="border rounded px-3 py-2 w-full focus:ring-1 focus:ring-blue-500">
                        <option value="">Todos</option>
                        @foreach($grupos as $grp)
                            <option value="{{ $grp }}" {{ request('grupo') == $grp ? 'selected' : '' }}>
                                {{ $grp }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            {{-- Botones --}}
            <div class="flex justify-end gap-3 mt-4">
                <a href="{{ route('admin.asistencias.index') }}"
                   class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                   Limpiar
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Filtrar
                </button>
            </div>
        </form>

        {{-- Tabla --}}
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr class="text-left text-sm font-semibold text-gray-700">
                        <th class="px-4 py-3">Docente</th>
                        <th class="px-4 py-3">Laboratorio</th>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Entrada</th>
                        <th class="px-4 py-3">Asignatura</th>
                        <th class="px-4 py-3">Grupo</th>
                        <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($asistencias as $asistencia)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm">
                                {{ $asistencia->usuario->nombre ?? '' }} {{ $asistencia->usuario->paterno ?? '' }}
                            </td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->laboratorio->nombre ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->fecha->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->entrada->format('H:i') }}</td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->asignatura ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->grupo ?? '-' }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ route('admin.asistencias.edit', $asistencia->idasistencia) }}"
                                   class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-sm">
                                   Editar
                                </a>
                                <form action="{{ route('admin.asistencias.inactivar', $asistencia->idasistencia) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Estás seguro de eliminar este registro?')">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                            class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition text-sm">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-400">
                                No se encontraron asistencias.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="p-4">
                {{ $asistencias->withQueryString()->links() }}
            </div>
        </div>

    </div>

    <script>
    const docentesData = @json($docentes);

    function autocomplete() {
        return {
            query: '{{ request("idusuario") ? $docentes->where("id", request("idusuario"))->first()?->nombre . " " . $docentes->where("id", request("idusuario"))->first()?->paterno : "" }}',
            selectedId: '{{ request("idusuario") ?? "" }}',
            results: [],
            data: docentesData,

            search() {
                if (this.query.length < 1) {
                    this.results = [];
                    this.selectedId = '';
                    return;
                }
                this.results = this.data.filter(u =>
                    (u.nombre + ' ' + u.paterno).toLowerCase().includes(this.query.toLowerCase())
                );
            },

            select(user) {
                this.query = user.nombre + ' ' + user.paterno;
                this.selectedId = user.id;
                this.results = [];
            }
        }
    }
    </script>

</x-app-layout>
