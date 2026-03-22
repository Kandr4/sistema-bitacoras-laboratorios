<x-app-layout>
    <x-slot name="header">
         <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Incidencias
            </h2>
            <div class="flex gap-2">
               
                <a href="/admin"
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition flex items-center gap-1">
                ⬅ Regresar
                </a>
            </div>
            


         </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto space-y-6">

        {{-- Filtros --}}
        <form method="GET" class="bg-white p-6 rounded-lg shadow space-y-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Filtrar incidencias</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                <div class="flex flex-col">
                    <label class="text-gray-600 font-medium mb-1">Fecha inicio</label>
                    <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" 
                           class="border rounded px-3 py-2 w-full focus:ring-1 focus:ring-blue-500">
                </div>

                <div class="flex flex-col">
                    <label class="text-gray-600 font-medium mb-1">Fecha fin</label>
                    <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" 
                           class="border rounded px-3 py-2 w-full focus:ring-1 focus:ring-blue-500">
                </div>

                <div x-data="autocomplete()" class="flex flex-col relative">
                    <label class="text-gray-600 font-medium mb-1">Profesores</label>
                    <input type="text" 
                        x-model="query" 
                        @input="search()" 
                        placeholder="Buscar profesor..." 
                        class="border rounded px-3 py-2 w-full focus:ring-1 focus:ring-blue-500">

                    <input type="hidden" name="idusuario" x-model="selectedId">

                    <ul x-show="results.length > 0" 
                        class="absolute z-10 bg-white border rounded w-full mt-1 max-h-60 overflow-auto shadow">
                        <template x-for="user in results" :key="user.id">
                            <li @click="select(user)" 
                                class="px-3 py-2 cursor-pointer hover:bg-blue-100" 
                                x-text="user.nombre + ' ' + user.paterno"></li>
                        </template>
                    </ul>
                </div>

                <div class="flex flex-col">
                    <label class="text-gray-600 font-medium mb-1">Laboratorio</label>
                    <select name="idlab" class="border rounded px-3 py-2 w-full focus:ring-1 focus:ring-blue-500">
                        <option value="">Todos</option>
                        @foreach($laboratorios as $lab)
                            <option value="{{ $lab->idlab }}" {{ request('idlab') == $lab->idlab ? 'selected' : '' }}>
                                {{ $lab->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col">
                    <label class="text-gray-600 font-medium mb-1">Técnico</label>
                    <select name="tecnico_id" class="border rounded px-3 py-2 w-full focus:ring-1 focus:ring-blue-500">
                        <option value="">Todos</option>
                        @foreach($tecnicos as $tec)
                            <option value="{{ $tec->id }}" {{ request('tecnico_id') == $tec->id ? 'selected' : '' }}>
                                {{ $tec->nombre }} {{ $tec->paterno }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            {{-- Botones --}}
            <div class="flex justify-end gap-3 mt-4">
                <a href="{{ route('admin.incidencias.index') }}" 
                   class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                   Limpiar
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Filtrar
                </button>
            </div>
        </form>

        {{-- Tabla de incidencias --}}
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr class="text-left text-sm font-semibold text-gray-700">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Fecha</th>
                        <th class="px-4 py-2">Laboratorio</th>
                        <th class="px-4 py-2">Usuario</th>
                        <th class="px-4 py-2">Técnico</th>
                        <th class="px-4 py-2">Estado</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($incidencias as $inc)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm">{{ $inc->idincidencia }}</td>
                            <td class="px-4 py-2 text-sm">{{ \Carbon\Carbon::parse($inc->fechahora)->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-2 text-sm">{{ $inc->laboratorio->nombre ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $inc->usuario->nombre ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm">{{ $inc->tecnico->nombre ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm">
                                <span class="px-2 py-1 rounded text-white text-xs
                                    @if($inc->estado == 'pendiente') bg-yellow-500
                                    @elseif($inc->estado == 'en proceso') bg-blue-500
                                    @elseif($inc->estado == 'resuelto') bg-green-500
                                    @else bg-gray-500 @endif">
                                    {{ ucfirst($inc->estado) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ route('admin.incidencias.edit', $inc->idincidencia) }}"
                                   class="px-2 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-sm">
                                   Editar
                                </a>
                                @if($inc->estado != 'inactivo')
                                    <form action="{{ route('admin.incidencias.inactivar', $inc->idincidencia) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                                class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition text-sm">
                                            Inactivar
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
                {{ $incidencias->withQueryString()->links() }}
            </div>
        </div>

    </div>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- jQuery (requerido por Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
const usuariosData = @json($usuarios->where("rol", "Profesor")->values());

function autocomplete() {
    return {
        query: '{{ request("idusuario") ? $usuarios->where("id", request("idusuario"))->first()->nombre . " " . $usuarios->where("id", request("idusuario"))->first()->paterno : "" }}',
        selectedId: '{{ request("idusuario") ?? "" }}',
        results: [],
        data: usuariosData,

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