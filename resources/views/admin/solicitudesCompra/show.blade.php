<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Solicitud de Compra #{{ $solicitud->id }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">

        {{-- Información de la solicitud --}}
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Detalles de la Solicitud</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600"><span class="font-semibold">Laboratorio:</span> {{ $solicitud->laboratorio->nombre }}</p>
                    <p class="text-gray-600"><span class="font-semibold">Creador:</span> {{ $solicitud->tecnico->nombre }} {{ $solicitud->tecnico->paterno }}</p>
                </div>
                <div>
                    <p class="text-gray-600"><span class="font-semibold">Estado actual:</span>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                        @if($solicitud->estado == 'autorizada') bg-green-100 text-green-800
                        @elseif($solicitud->estado == 'rechazada') bg-red-100 text-red-800
                        @elseif($solicitud->estado == 'en proceso') bg-yellow-100 text-yellow-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($solicitud->estado) }}
                        </span>
                    </p>
                    <p class="text-gray-600"><span class="font-semibold">Comentario administrativo:</span> {{ $solicitud->comentario_admin ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Formulario para actualizar estado --}}
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Actualizar Estado</h3>
            <form action="{{ route('admin.solicitudesCompra.actualizarEstado', $solicitud->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Nuevo Estado:</label>
                    <select name="estado" required class="border rounded px-3 py-2 w-full focus:ring-1 focus:ring-blue-500">
                        <option value="autorizada" {{ $solicitud->estado == 'autorizada' ? 'selected' : '' }}>Autorizada</option>
                        <option value="rechazada" {{ $solicitud->estado == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                        <option value="en proceso" {{ $solicitud->estado == 'en proceso' ? 'selected' : '' }}>En proceso</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Comentario:</label>
                    <textarea name="comentario_admin" rows="4" class="border rounded w-full px-3 py-2 focus:ring-1 focus:ring-blue-500" placeholder="Agregar comentario">{{ $solicitud->comentario_admin }}</textarea>
                </div>

                <div class="flex gap-2 mt-4">
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white font-semibold rounded shadow hover:bg-green-700 transition">
                        Actualizar
                    </button>
                    <a href="{{ route('admin.solicitudesCompra.index') }}" class="px-6 py-2 bg-gray-400 text-white font-semibold rounded shadow hover:bg-gray-500 transition">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>