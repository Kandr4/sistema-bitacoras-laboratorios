<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Reportar Falla
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">

        <div class="bg-white p-6 rounded-lg shadow">
            <form action="{{ route('profesor.fallas.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- LABORATORIO --}}
                    <div>
                        <label class="block text-gray-600 font-medium mb-1">Laboratorio</label>
                        <select name="laboratorio_id" class="w-full border rounded px-3 py-2">
                            @foreach($laboratorios as $lab)
                                <option value="{{ $lab->idlab }}">{{ $lab->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- EQUIPO --}}
                    <div>
                        <label class="block text-gray-600 font-medium mb-1">Equipo</label>
                        <select name="equipo_id" class="w-full border rounded px-3 py-2">
                            @foreach($equipos as $equipo)
                                <option value="{{ $equipo->id }}">{{ $equipo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- TIPO --}}
                    <div class="md:col-span-2">
                        <label class="block text-gray-600 font-medium mb-1">Tipo de falla</label>
                        <select name="tipo_falla" class="w-full border rounded px-3 py-2">
                            <option value="hardware">Hardware</option>
                            <option value="software">Software</option>
                            <option value="red">Red</option>
                            <option value="perifericos">Periféricos</option>
                            <option value="otros">Otros</option>
                        </select>
                    </div>

                    {{-- DESCRIPCIÓN --}}
                    <div class="md:col-span-2">
                        <label class="block text-gray-600 font-medium mb-1">Descripción</label>
                        <textarea name="descripcion" rows="4"
                            class="w-full border rounded px-3 py-2"></textarea>
                    </div>

                </div>

                {{-- BOTONES --}}
                <div class="flex justify-between mt-4">
                    <a href="{{ route('profesor.fallas.index') }}" 
                       class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Guardar
                    </button>
                </div>

            </form>
        </div>

    </div>
</x-app-layout>