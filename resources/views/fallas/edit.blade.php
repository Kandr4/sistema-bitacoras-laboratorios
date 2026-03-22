<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Editar Falla
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg p-6">

            <h3 class="text-lg font-semibold text-gray-700 mb-4">
                Actualizar información de la falla
            </h3>

            <form action="{{ route('fallas.update', $falla) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Laboratorio --}}
                <div>
                    <label class="block text-gray-600 font-medium mb-1">Laboratorio</label>
                    <select name="laboratorio_id"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        @foreach($laboratorios as $lab)
                            <option value="{{ $lab->idlab }}"
                                {{ $falla->laboratorio_id == $lab->idlab ? 'selected' : '' }}>
                                {{ $lab->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Equipo --}}
                <div>
                    <label class="block text-gray-600 font-medium mb-1">Equipo</label>
                    <select name="equipo_id"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        @foreach($equipos as $equipo)
                            <option value="{{ $equipo->id }}"
                                {{ $falla->equipo_id == $equipo->id ? 'selected' : '' }}>
                                {{ $equipo->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tipo de falla --}}
                <div>
                    <label class="block text-gray-600 font-medium mb-1">Tipo de falla</label>
                    <select name="tipo_falla"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        <option value="hardware" {{ $falla->tipo_falla == 'hardware' ? 'selected' : '' }}>Hardware</option>
                        <option value="software" {{ $falla->tipo_falla == 'software' ? 'selected' : '' }}>Software</option>
                        <option value="red" {{ $falla->tipo_falla == 'red' ? 'selected' : '' }}>Red / Conectividad</option>
                        <option value="perifericos" {{ $falla->tipo_falla == 'perifericos' ? 'selected' : '' }}>Periféricos</option>
                        <option value="otros" {{ $falla->tipo_falla == 'otros' ? 'selected' : '' }}>Otros</option>
                    </select>
                </div>

                {{-- Descripción --}}
                <div>
                    <label class="block text-gray-600 font-medium mb-1">Descripción</label>
                    <textarea name="descripcion" rows="4"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">{{ $falla->descripcion }}</textarea>
                </div>

                {{-- Estado (solo técnicos/admin) --}}
                @if(auth()->user()->rol === 'Técnico' || auth()->user()->rol === 'Administrador')
                <div>
                    <label class="block text-gray-600 font-medium mb-1">Estado</label>
                    <select name="estado"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        <option value="pendiente" {{ $falla->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="en revision" {{ $falla->estado == 'en revision' ? 'selected' : '' }}>En revisión</option>
                        <option value="resuelto" {{ $falla->estado == 'resuelto' ? 'selected' : '' }}>Resuelto</option>
                    </select>
                </div>
                @endif

                {{-- Botones --}}
                <div class="flex justify-end gap-2 pt-4">
                    <a href="{{ route('fallas.index') }}"
                       class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition shadow">
                        Actualizar
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>