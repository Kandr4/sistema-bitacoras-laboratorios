<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registro de Asistencia
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-xl rounded-2xl p-8 text-center">

                @if($exito)
                    <!-- Registro exitoso -->
                    <div class="mb-6">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-100 mb-4">
                            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-green-700 mb-2">{{ $mensaje }}</h3>
                    </div>

                    {{-- Mensaje de éxito al guardar datos de práctica --}}
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Datos de la asistencia --}}
                    <div class="bg-gray-50 rounded-xl p-6 text-left space-y-3 mb-6">
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500 font-medium">Profesor:</span>
                            <span class="text-gray-800 font-semibold">{{ $usuario->nombre }} {{ $usuario->paterno }} {{ $usuario->materno }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500 font-medium">Laboratorio:</span>
                            <span class="text-gray-800 font-semibold">{{ $laboratorio->nombre }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500 font-medium">Fecha:</span>
                            <span class="text-gray-800 font-semibold">{{ $asistencia->fecha->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 font-medium">Hora de entrada:</span>
                            <span class="text-gray-800 font-semibold">{{ $asistencia->entrada->format('H:i:s') }}</span>
                        </div>

                        {{-- Mostrar datos de práctica si ya fueron guardados --}}
                        @if($asistencia->asignatura)
                            <div class="border-t pt-3 mt-3">
                                <h4 class="text-sm font-semibold text-indigo-600 uppercase tracking-wide mb-2">Datos de la Práctica</h4>
                                <div class="flex justify-between border-b pb-2">
                                    <span class="text-gray-500 font-medium">Asignatura:</span>
                                    <span class="text-gray-800 font-semibold">{{ $asistencia->asignatura }}</span>
                                </div>
                                <div class="flex justify-between border-b pb-2 pt-2">
                                    <span class="text-gray-500 font-medium">Cuatrimestre:</span>
                                    <span class="text-gray-800 font-semibold">{{ $asistencia->cuatrimestre }}°</span>
                                </div>
                                <div class="flex justify-between border-b pb-2 pt-2">
                                    <span class="text-gray-500 font-medium">Grupo:</span>
                                    <span class="text-gray-800 font-semibold">{{ $asistencia->grupo }}</span>
                                </div>
                                <div class="flex justify-between border-b pb-2 pt-2">
                                    <span class="text-gray-500 font-medium">Carrera:</span>
                                    <span class="text-gray-800 font-semibold">{{ $asistencia->carrera }}</span>
                                </div>
                                <div class="flex justify-between pt-2">
                                    <span class="text-gray-500 font-medium">Práctica:</span>
                                    <span class="text-gray-800 font-semibold">{{ $asistencia->nombre_practica }}</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Formulario de datos de práctica (solo si no se han guardado aún) --}}
                    @if(!$asistencia->asignatura)
                        <div class="bg-indigo-50 rounded-xl p-6 text-left border border-indigo-100">
                            <h4 class="text-lg font-bold text-indigo-700 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Completar datos de la práctica
                            </h4>

                            <form action="{{ route('asistencia.guardarDatos', $asistencia->idasistencia) }}" method="POST" class="space-y-4">
                                @csrf

                                {{-- Asignatura --}}
                                <div>
                                    <label for="asignatura" class="block text-sm font-medium text-gray-700 mb-1">Asignatura</label>
                                    <select name="asignatura" id="asignatura" required
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                        <option value="">Selecciona una asignatura</option>
                                        @foreach($asignaturas as $asignatura)
                                            <option value="{{ $asignatura }}" {{ old('asignatura') == $asignatura ? 'selected' : '' }}>
                                                {{ $asignatura }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('asignatura')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Cuatrimestre y Grupo en una fila --}}
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="cuatrimestre" class="block text-sm font-medium text-gray-700 mb-1">Cuatrimestre</label>
                                        <select name="cuatrimestre" id="cuatrimestre" required
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            <option value="">Selecciona</option>
                                            @foreach($cuatrimestres as $cuatrimestre)
                                                <option value="{{ $cuatrimestre }}" {{ old('cuatrimestre') == $cuatrimestre ? 'selected' : '' }}>
                                                    {{ $cuatrimestre }}° Cuatrimestre
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('cuatrimestre')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="grupo" class="block text-sm font-medium text-gray-700 mb-1">Grupo</label>
                                        <select name="grupo" id="grupo" required
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            <option value="">Selecciona</option>
                                            @foreach($grupos as $grupo)
                                                <option value="{{ $grupo }}" {{ old('grupo') == $grupo ? 'selected' : '' }}>
                                                    {{ $grupo }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('grupo')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Carrera --}}
                                <div>
                                    <label for="carrera" class="block text-sm font-medium text-gray-700 mb-1">Carrera</label>
                                    <select name="carrera" id="carrera" required
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                        <option value="">Selecciona una carrera</option>
                                        @foreach($carreras as $carrera)
                                            <option value="{{ $carrera }}" {{ old('carrera') == $carrera ? 'selected' : '' }}>
                                                {{ $carrera }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('carrera')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Nombre de la práctica --}}
                                <div>
                                    <label for="nombre_practica" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la práctica</label>
                                    <input type="text" name="nombre_practica" id="nombre_practica" required
                                        value="{{ old('nombre_practica') }}"
                                        placeholder="Ej: Práctica 1 - Instalación de redes"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                    @error('nombre_practica')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="pt-2">
                                    <button type="submit"
                                        class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg shadow hover:bg-indigo-700 transition font-semibold">
                                        Guardar datos de la práctica
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif

                    <div class="mt-6">
                        <a href="{{ url('/profesor') }}"
                            class="bg-indigo-600 text-white px-6 py-2 rounded-lg shadow hover:bg-indigo-700 transition">
                            Ir al Dashboard
                        </a>
                    </div>

                @else
                    <!-- Error -->
                    <div class="mb-6">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-red-100 mb-4">
                            <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-red-700 mb-2">No se pudo registrar</h3>
                        <p class="text-gray-600">{{ $mensaje }}</p>
                    </div>

                    <div class="mt-6">
                        <a href="{{ url('/') }}"
                            class="bg-gray-600 text-white px-6 py-2 rounded-lg shadow hover:bg-gray-700 transition">
                            Volver al inicio
                        </a>
                    </div>
                @endif

            </div>

        </div>
    </div>

</x-app-layout>
