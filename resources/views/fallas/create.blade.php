<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Reporte de Falla
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg p-6">

            <h3 class="text-lg font-semibold text-gray-700 mb-4">
                Registrar nueva falla
            </h3>

            @php
                $storeRoute = Auth::user()->rol === 'Profesor' ? route('profesor.fallas.store') : route('fallas.store');
                $indexRoute = Auth::user()->rol === 'Profesor' ? route('profesor.fallas.index') : route('fallas.index');
            @endphp

            <form action="{{ $storeRoute }}" method="POST" class="space-y-5">
                @csrf

                {{-- Laboratorio --}}
                <div>
                    <label class="block text-gray-600 font-medium mb-1">Laboratorio</label>
                    <select name="laboratorio_id"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        <option value="">Selecciona un laboratorio</option>
                        @foreach($laboratorios as $lab)
                            <option value="{{ $lab->idlab }}">{{ $lab->nombre }}</option>
                        @endforeach
                    </select>
                    @error('laboratorio_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Equipo --}}
                <div>
                    <label class="block text-gray-600 font-medium mb-1">Equipo</label>
                    <select name="equipo_id"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        <option value="">Selecciona un equipo</option>
                        @foreach($equipos as $equipo)
                            <option value="{{ $equipo->id }}">{{ $equipo->nombre }}</option>
                        @endforeach
                    </select>
                    @error('equipo_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Tipo de falla --}}
                <div>
                    <label class="block text-gray-600 font-medium mb-1">Tipo de falla</label>
                    <select name="tipo_falla"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        <option value="">Selecciona tipo</option>
                        <option value="hardware">Hardware</option>
                        <option value="software">Software</option>
                        <option value="red">Red / Conectividad</option>
                        <option value="perifericos">Periféricos</option>
                        <option value="otros">Otros</option>
                    </select>
                    @error('tipo_falla')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div>
                    <label class="block text-gray-600 font-medium mb-1">Descripción</label>
                    <textarea name="descripcion" rows="4"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                        placeholder="Describe el problema..."></textarea>
                    @error('descripcion')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Botones --}}
                <div class="flex justify-end gap-2 pt-4">
                    <a href="{{ $indexRoute }}"
                       class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                        Cancelar
                    </a>

                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition shadow">
                        Registrar falla
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>