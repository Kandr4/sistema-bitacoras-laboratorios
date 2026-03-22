<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               Incidencia #{{ $incidencia->idincidencia }}
            </h2>

            <a href="{{ route('tecnico.incidencias.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition flex items-center gap-1">
               ⬅ Regresar
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto space-y-6">

        {{-- Información general --}}
        <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200">
            <h3 class="text-xl font-bold text-gray-700 mb-4">Detalles de la Incidencia</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <p><span class="font-semibold text-gray-600">Laboratorio:</span> {{ $incidencia->laboratorio->nombre ?? '-' }}</p>
                    <p><span class="font-semibold text-gray-600">Usuario involucrado:</span> {{ $incidencia->usuario->nombre ?? '-' }} {{ $incidencia->usuario->paterno ?? '' }}</p>
                    <p><span class="font-semibold text-gray-600">Técnico responsable:</span> {{ $incidencia->tecnico->nombre }} {{ $incidencia->tecnico->paterno }}</p>
                </div>
                <div class="space-y-2">
                    <p><span class="font-semibold text-gray-600">Fecha y hora:</span> {{ \Carbon\Carbon::parse($incidencia->fechahora)->format('d/m/Y H:i') }}</p>
                    <p>
                        <span class="font-semibold text-gray-600">Estado:</span>
                        @switch($incidencia->estado)
                            @case('pendiente')
                                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Pendiente</span>
                                @break
                            @case('en proceso')
                                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">En proceso</span>
                                @break
                            @case('resuelto')
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Resuelto</span>
                                @break
                            @default
                                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">Desconocido</span>
                        @endswitch
                    </p>
                    <p>
                        <span class="font-semibold text-gray-600">Firma:</span><br>
                        @if($incidencia->firmadigital)
                            <img src="{{ $incidencia->firmadigital }}" alt="Firma" class="h-20 mt-1 border rounded">
                        @else
                            <span class="text-gray-400">No disponible</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="mt-4 space-y-2">
                <p><span class="font-semibold text-gray-600">Descripción:</span> {{ $incidencia->descripcion }}</p>
                <p><span class="font-semibold text-gray-600">Solución:</span> {{ $incidencia->solucion ?? '-' }}</p>
                <p><span class="font-semibold text-gray-600">Observaciones:</span> {{ $incidencia->observaciones ?? '-' }}</p>
            </div>
        </div>

        {{-- Formulario de actualización --}}
        <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200">
            <h3 class="text-xl font-bold text-gray-700 mb-4">Actualizar Incidencia</h3>

            <form action="{{ route('tecnico.incidencias.update', $incidencia->idincidencia) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Laboratorio --}}
                    <div>
                        <label class="block font-medium text-gray-700">Laboratorio</label>
                        <select name="idlab" required class="border rounded px-3 py-2 w-full focus:ring-1 focus:ring-blue-500">
                            @foreach($laboratorios as $lab)
                                <option value="{{ $lab->idlab }}" {{ $incidencia->idlab == $lab->idlab ? 'selected' : '' }}>
                                    {{ $lab->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Usuario --}}
                    <div>
                        <label class="block font-medium text-gray-700">Usuario involucrado</label>
                        <select name="idusuario" class="border rounded px-3 py-2 w-full focus:ring-1 focus:ring-blue-500">
                            <option value="">Ninguno</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ $incidencia->idusuario == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->nombre }} {{ $usuario->paterno }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Fecha y hora --}}
                <div>
                    <label class="block font-medium text-gray-700">Fecha y hora</label>
                    <input type="datetime-local" name="fechahora" value="{{ \Carbon\Carbon::parse($incidencia->fechahora)->format('Y-m-d\TH:i') }}" 
                           class="border rounded px-3 py-2 w-full focus:ring-1 focus:ring-blue-500">
                </div>

                {{-- Descripción, Solución, Observaciones --}}
                <div>
                    <label class="block font-medium text-gray-700">Descripción</label>
                    <textarea name="descripcion" class="border rounded w-full px-3 py-2 focus:ring-1 focus:ring-blue-500">{{ $incidencia->descripcion }}</textarea>
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Solución</label>
                    <textarea name="solucion" class="border rounded w-full px-3 py-2 focus:ring-1 focus:ring-blue-500">{{ $incidencia->solucion }}</textarea>
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Observaciones</label>
                    <textarea name="observaciones" class="border rounded w-full px-3 py-2 focus:ring-1 focus:ring-blue-500">{{ $incidencia->observaciones }}</textarea>
                </div>

                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Guardar cambios
                </button>
            </form>
        </div>
    </div>
</x-app-layout>