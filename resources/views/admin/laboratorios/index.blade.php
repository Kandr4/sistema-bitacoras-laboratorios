<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Laboratorios
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-xl rounded-2xl p-6">

                <!-- Botón -->
                <div class="flex justify-between items-center mb-6">
                    <!-- Botón regresar -->
                    <a href="{{ url('/admin') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-600 transition">
                        ← Regresar
                    </a>
                
                <h3 class="text-lg font-semibold text-gray-700">
                        Lista de Laboratorios
                    </h3>

                    <a href="{{ route('admin.laboratorios.create') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                        + Nuevo laboratorio
                    </a>
                    
                </div>

                <!-- Mensaje de éxito -->
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Tabla -->
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">

                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="py-3 px-4 text-left">ID</th>
                                <th class="py-3 px-4 text-left">Nombre</th>
                                <th class="py-3 px-4 text-left">Ubicación</th>
                                <th class="py-3 px-4 text-left">Estado</th>
                                <th class="py-3 px-4 text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($laboratorios as $lab)
                                <tr class="border-t hover:bg-gray-50">

                                    <td class="py-3 px-4">{{ $lab->idlab }}</td>

                                    <td class="py-3 px-4">
                                        {{ $lab->nombre }}
                                    </td>

                                    <td class="py-3 px-4">
                                        {{ $lab->ubicacion }}
                                    </td>

                                    <td class="py-3 px-4">
                                        @if($lab->estado)
                                            <span class="text-green-600 font-semibold">Activo</span>
                                        @else
                                            <span class="text-red-600 font-semibold">Inactivo</span>
                                        @endif
                                    </td>

                                    <td class="py-3 px-4 text-center flex gap-2 justify-center">

                                        <!-- Editar -->
                                        <a href="{{ route('admin.laboratorios.edit', $lab->idlab) }}"
                                            class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">
                                            Editar
                                        </a>

                                        <!-- Ver QR -->
                                        @if($lab->qr_token)
                                            <a href="{{ route('admin.laboratorios.qr.ver', $lab->idlab) }}"
                                                class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">
                                                📱 QR
                                            </a>
                                        @else
                                            <form action="{{ route('admin.laboratorios.qr.generar', $lab->idlab) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-indigo-500 text-white px-3 py-1 rounded hover:bg-indigo-600">
                                                    Generar QR
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Eliminar -->
                                        <form action="{{ route('admin.laboratorios.destroy', $lab->idlab) }}" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                onclick="return confirm('¿Eliminar laboratorio?')"
                                                class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                                Eliminar
                                            </button>
                                        </form>

                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-gray-500">
                                        No hay laboratorios registrados
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>

        </div>
    </div>

</x-app-layout>