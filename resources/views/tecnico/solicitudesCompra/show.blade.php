<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle de Solicitud de Compra
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                
                {{-- Header de la tarjeta --}}
                <div class="bg-blue-600 text-white px-6 py-4">
                    <h3 class="text-lg font-bold">Solicitud #{{ $solicitud->id }}</h3>
                    <p class="text-sm">Laboratorio: {{ $solicitud->laboratorio->nombre }}</p>
                    <span class="inline-block mt-1 px-2 py-1 bg-gray-200 text-gray-800 rounded">
                        Estado: {{ ucfirst($solicitud->estado) }}
                    </span>
                </div>

                {{-- Contenido --}}
                <div class="px-6 py-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p><span class="font-semibold">Cantidad:</span> {{ $solicitud->cantidad }}</p>
                        <p><span class="font-semibold">Costo Unitario:</span> ${{ number_format($solicitud->costo_unitario,2) }}</p>
                        <p><span class="font-semibold">Características:</span> {{ $solicitud->caracteristicas }}</p>
                    </div>
                    <div>
                        <p><span class="font-semibold">Descripción:</span> {{ $solicitud->descripcion }}</p>
                        <p><span class="font-semibold">Justificación:</span> {{ $solicitud->justificacion }}</p>
                        @if($solicitud->imagen)
                            <p class="mt-2 font-semibold">Imagen:</p>
                            <img src="{{ asset('storage/'.$solicitud->imagen) }}" alt="Imagen" class="rounded shadow mt-1 max-w-full h-auto">
                        @endif
                    </div>
                </div>

                {{-- Footer con botón --}}
                <div class="px-6 py-4 bg-gray-50 flex justify-end">
                    <a href="{{ route('tecnico.solicitudesCompra.index') }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                       Regresar
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>