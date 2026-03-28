<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ✏️ Editar Asistencia
            </h2>
            <a href="{{ route('admin.asistencias.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition flex items-center gap-1">
                ⬅ Regresar
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">

        {{-- Errores de validación --}}
        @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                <ul class="list-disc pl-5 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow rounded-xl p-6">

            {{-- Info del docente (solo lectura) --}}
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-500">Docente</p>
                <p class="font-semibold text-gray-800">
                    {{ $asistencia->usuario->nombre ?? '' }}
                    {{ $asistencia->usuario->paterno ?? '' }}
                    {{ $asistencia->usuario->materno ?? '' }}
                </p>
            </div>

            <form action="{{ route('admin.asistencias.update', $asistencia->idasistencia) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Laboratorio --}}
                <div>
                    <label for="idlaboratorio" class="block text-sm font-medium text-gray-700 mb-1">Laboratorio</label>
                    <select name="idlaboratorio" id="idlaboratorio" required
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        @foreach($laboratorios as $lab)
                            <option value="{{ $lab->idlab }}"
                                {{ old('idlaboratorio', $asistencia->idlaboratorio) == $lab->idlab ? 'selected' : '' }}>
                                {{ $lab->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Fecha, Entrada y Salida --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="fecha" class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                        <input type="date" name="fecha" id="fecha" required
                            value="{{ old('fecha', $asistencia->fecha->format('Y-m-d')) }}"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div>
                        <label for="entrada" class="block text-sm font-medium text-gray-700 mb-1">Hora de entrada</label>
                        <input type="datetime-local" name="entrada" id="entrada" required
                            value="{{ old('entrada', $asistencia->entrada->format('Y-m-d\TH:i')) }}"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div>
                        <label for="salida" class="block text-sm font-medium text-gray-700 mb-1">Hora de salida</label>
                        <input type="datetime-local" name="salida" id="salida"
                            value="{{ old('salida', $asistencia->salida ? $asistencia->salida->format('Y-m-d\TH:i') : '') }}"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                </div>

                <hr class="my-2">
                <h4 class="text-sm font-semibold text-indigo-600 uppercase tracking-wide">Datos de la Práctica</h4>

                {{-- Asignatura --}}
                <div>
                    <label for="asignatura" class="block text-sm font-medium text-gray-700 mb-1">Asignatura</label>
                    <select name="asignatura" id="asignatura"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <option value="">Sin asignar</option>
                        @foreach($asignaturas as $asig)
                            <option value="{{ $asig }}"
                                {{ old('asignatura', $asistencia->asignatura) == $asig ? 'selected' : '' }}>
                                {{ $asig }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Cuatrimestre y Grupo --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="cuatrimestre" class="block text-sm font-medium text-gray-700 mb-1">Cuatrimestre</label>
                        <select name="cuatrimestre" id="cuatrimestre"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="">Sin asignar</option>
                            @foreach($cuatrimestres as $cuat)
                                <option value="{{ $cuat }}"
                                    {{ old('cuatrimestre', $asistencia->cuatrimestre) == $cuat ? 'selected' : '' }}>
                                    {{ $cuat }}° Cuatrimestre
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="grupo" class="block text-sm font-medium text-gray-700 mb-1">Grupo</label>
                        <select name="grupo" id="grupo"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="">Sin asignar</option>
                            @foreach($grupos as $grp)
                                <option value="{{ $grp }}"
                                    {{ old('grupo', $asistencia->grupo) == $grp ? 'selected' : '' }}>
                                    {{ $grp }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Carrera --}}
                <div>
                    <label for="carrera" class="block text-sm font-medium text-gray-700 mb-1">Carrera</label>
                    <select name="carrera" id="carrera"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <option value="">Sin asignar</option>
                        @foreach($carreras as $carr)
                            <option value="{{ $carr }}"
                                {{ old('carrera', $asistencia->carrera) == $carr ? 'selected' : '' }}>
                                {{ $carr }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Nombre de la práctica --}}
                <div>
                    <label for="nombre_practica" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la práctica</label>
                    <input type="text" name="nombre_practica" id="nombre_practica"
                        value="{{ old('nombre_practica', $asistencia->nombre_practica) }}"
                        placeholder="Nombre de la práctica"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                </div>

                {{-- Botón guardar --}}
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('admin.asistencias.index') }}"
                       class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition font-semibold">
                        Guardar cambios
                    </button>
                </div>
            </form>

        </div>
    </div>

</x-app-layout>
