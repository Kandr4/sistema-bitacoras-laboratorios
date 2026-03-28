<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📋 Asistencias de Profesores
            </h2>
            <a href="/tecnico"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition flex items-center gap-1">
                ⬅ Regresar
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Filtros --}}
        <form method="GET" class="bg-white p-6 rounded-lg shadow space-y-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Filtrar asistencias</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

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

                {{-- Docente --}}
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

            </div>

            {{-- Botones --}}
            <div class="flex justify-end gap-3 mt-4">
                <a href="{{ route('tecnico.asistencias.index') }}"
                   class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                   Limpiar
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Filtrar
                </button>
            </div>
        </form>

        {{-- Tabla de asistencias --}}
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr class="text-left text-sm font-semibold text-gray-700">
                        <th class="px-4 py-3">Docente</th>
                        <th class="px-4 py-3">Laboratorio</th>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Entrada</th>
                        <th class="px-4 py-3">Salida</th>
                        <th class="px-4 py-3">Permanencia</th>
                        <th class="px-4 py-3">Asignatura</th>
                        <th class="px-4 py-3">Cuatrimestre</th>
                        <th class="px-4 py-3">Grupo</th>
                        <th class="px-4 py-3">Carrera</th>
                        <th class="px-4 py-3">Práctica</th>
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
                            <td class="px-4 py-2 text-sm">{{ $asistencia->salida ? $asistencia->salida->format('H:i') : '-' }}</td>
                            <td class="px-4 py-2 text-sm">
                                @if($asistencia->salida)
                                    @php
                                        $diff = $asistencia->entrada->diff($asistencia->salida);
                                        $perm = '';
                                        if ($diff->h > 0) $perm .= $diff->h . 'h ';
                                        $perm .= $diff->i . 'min';
                                    @endphp
                                    {{ $perm }}
                                @else
                                    <span class="text-yellow-600 font-medium">En curso</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->asignatura ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->cuatrimestre ? $asistencia->cuatrimestre . '°' : '-' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->grupo ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->carrera ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $asistencia->nombre_practica ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-4 py-8 text-center text-gray-400">
                                No hay asistencias registradas.
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
