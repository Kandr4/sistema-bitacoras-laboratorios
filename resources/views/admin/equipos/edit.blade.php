<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Editar Equipo</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <form action="{{ route('admin.equipos.update', $equipo) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre', $equipo->nombre) }}" class="border rounded px-3 py-2 w-full">
                @error('nombre') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Laboratorio</label>
                <select name="laboratorio_id" class="border rounded px-3 py-2 w-full">
                    @foreach($laboratorios as $lab)
                        <option value="{{ $lab->idlab }}" {{ $equipo->laboratorio_id == $lab->idlab ? 'selected' : '' }}>{{ $lab->nombre }}</option>
                    @endforeach
                </select>
                @error('laboratorio_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Descripción</label>
                <textarea name="descripcion" class="border rounded px-3 py-2 w-full">{{ old('descripcion', $equipo->descripcion) }}</textarea>
                @error('descripcion') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

        <div class="flex justify-between items-center">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Actualizar</button>
            <div class="flex gap-2">
               
                <a href="{{ route('admin.equipos.index') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition flex items-center gap-1">
                Cancelar
                </a>
            </div>
            


         </div>
        
        
        </form>
    </div>
</x-app-layout>