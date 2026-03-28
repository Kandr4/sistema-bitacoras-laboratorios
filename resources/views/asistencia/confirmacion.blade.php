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

                    <div class="bg-gray-50 rounded-xl p-6 text-left space-y-3">
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
                    </div>

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
