<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Registro de Salida
            </h2>
            <a href="{{ route('profesor.asistencias.index') }}"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition flex items-center gap-1">
                ⬅ Regresar al historial
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-xl rounded-2xl p-8 text-center">

                {{-- Icono de éxito --}}
                <div class="mb-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-100 mb-4">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-green-700 mb-2">¡Salida registrada correctamente!</h3>
                </div>

                {{-- Datos de la asistencia --}}
                <div class="bg-gray-50 rounded-xl p-6 text-left space-y-3">
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-500 font-medium">Laboratorio:</span>
                        <span class="text-gray-800 font-semibold">{{ $asistencia->laboratorio->nombre ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-500 font-medium">Fecha:</span>
                        <span class="text-gray-800 font-semibold">{{ $asistencia->fecha->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-500 font-medium">Hora de entrada:</span>
                        <span class="text-gray-800 font-semibold">{{ $asistencia->entrada->format('H:i:s') }}</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-500 font-medium">Hora de salida:</span>
                        <span class="text-gray-800 font-semibold">{{ $asistencia->salida->format('H:i:s') }}</span>
                    </div>
                    <div class="flex justify-between pt-1">
                        <span class="text-gray-500 font-medium">Tiempo total de permanencia:</span>
                        <span class="text-indigo-700 font-bold text-lg">{{ $permanencia }}</span>
                    </div>
                </div>

                <div class="mt-6 flex justify-center gap-3">
                    <a href="{{ route('profesor.asistencias.index') }}"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-lg shadow hover:bg-indigo-700 transition">
                        Ver mi historial
                    </a>
                    <a href="{{ url('/profesor') }}"
                        class="bg-gray-500 text-white px-6 py-2 rounded-lg shadow hover:bg-gray-600 transition">
                        Ir al Dashboard
                    </a>
                </div>

            </div>

        </div>
    </div>

</x-app-layout>
