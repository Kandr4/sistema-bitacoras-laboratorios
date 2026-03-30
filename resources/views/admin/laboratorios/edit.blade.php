<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Laboratorio
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-xl rounded-2xl p-6">

                <div class="mb-6">
                    <a href="{{ route('admin.laboratorios.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded border border-gray-600 shadow hover:bg-gray-600 transition">
                        ← Cancelar
                    </a>
                </div>

                <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">
                    Información del Laboratorio
                </h3>

                <form action="{{ route('admin.laboratorios.update', $laboratorio->idlab) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-gray-700 font-bold mb-1">Nombre</label>
                        <input type="text" name="nombre" class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('nombre', $laboratorio->nombre) }}" required>
                        @error('nombre')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-1">Ubicación</label>
                        <input type="text" name="ubicacion" class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('ubicacion', $laboratorio->ubicacion) }}">
                        @error('ubicacion')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center gap-2 mt-4">
                        <input type="checkbox" name="estado" id="estado" value="1" class="rounded text-blue-600 focus:ring-blue-500" 
                            {{ old('estado', $laboratorio->estado === 'Activo' || $laboratorio->estado === '1' || $laboratorio->estado === 1) ? 'checked' : '' }}>
                        <label for="estado" class="text-gray-700 font-bold select-none cursor-pointer">
                            Laboratorio Activo
                        </label>
                    </div>

                    <div class="mt-8 text-right pt-4 border-t">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                            Actualizar Laboratorio
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</x-app-layout>
