<!-- resources/views/admin/incidencias/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               Editar Incidencia #{{ $incidencia->idincidencia }}
            </h2>

            <a href="{{ route('admin.incidencias.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition flex items-center gap-1">
               ⬅ Regresar
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto space-y-6">
        <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200">
            <h3 class="text-xl font-bold text-gray-700 mb-4">Actualizar Incidencia</h3>

            <form action="{{ route('admin.incidencias.update', $incidencia->idincidencia) }}" method="POST" class="space-y-4">
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

                {{-- Descripción --}}
                <div>
                    <label class="block font-medium text-gray-700">Descripción</label>
                    <textarea name="descripcion" class="border rounded w-full px-3 py-2 focus:ring-1 focus:ring-blue-500">{{ $incidencia->descripcion }}</textarea>
                </div>

                {{-- Solución --}}
                <div>
                    <label class="block font-medium text-gray-700">Solución</label>
                    <textarea name="solucion" class="border rounded w-full px-3 py-2 focus:ring-1 focus:ring-blue-500">{{ $incidencia->solucion }}</textarea>
                </div>

                {{-- Observaciones --}}
                <div>
                    <label class="block font-medium text-gray-700">Observaciones</label>
                    <textarea name="observaciones" class="border rounded w-full px-3 py-2 focus:ring-1 focus:ring-blue-500">{{ $incidencia->observaciones }}</textarea>
                </div>

                {{-- Estado --}}
                <div>
                    <label class="block font-medium text-gray-700">Estado</label>
                    <select name="estado" class="border rounded px-3 py-2 w-full focus:ring-1 focus:ring-blue-500">
                        <option value="pendiente" {{ $incidencia->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="en proceso" {{ $incidencia->estado == 'en proceso' ? 'selected' : '' }}>En proceso</option>
                        <option value="resuelto" {{ $incidencia->estado == 'resuelto' ? 'selected' : '' }}>Resuelto</option>
                        <option value="inactivo" {{ $incidencia->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Guardar cambios
                </button>
            </form>
        </div>
    </div>
</x-app-layout>