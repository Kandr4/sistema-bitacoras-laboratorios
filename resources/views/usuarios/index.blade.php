<x-app-layout>

    <div class="p-8 max-w-7xl mx-auto">

        {{-- Título y botón regresar --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Lista de Usuarios</h1>

            <a href="/admin" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition">
                Regresar
            </a>
        </div>

        <table class="w-full border rounded overflow-hidden">

            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3 text-left">Nombre</th>
                    <th class="p-3 text-left">Correo</th>
                    <th class="p-3 text-left">Rol</th>
                    <th class="p-3 text-left">Estado</th>
                    <th class="p-3 text-left">Acciones</th>
                </tr>
            </thead>

            <tbody>

                @foreach($usuarios as $usuario)
                    <tr class="border-b hover:bg-gray-50">

                        <td class="p-3">
                            {{ $usuario->nombre }} {{ $usuario->paterno }}
                        </td>

                        <td class="p-3">
                            {{ $usuario->email }}
                        </td>

                        <td class="p-3">
                            {{ ucfirst($usuario->rol) }}
                        </td>

                        <td class="p-3">
                            @if($usuario->estado)
                                <span class="text-green-600 font-semibold">Activo</span>
                            @else
                                <span class="text-red-600 font-semibold">Inactivo</span>
                            @endif
                        </td>

                        <td class="p-3 flex gap-2">
                            <!-- Editar -->
                            <a href="{{ route('usuarios.edit', $usuario->id) }}" 
                               class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                Editar
                            </a>

                            <!-- Eliminar -->
                            <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" 
                                  onsubmit="return confirm('¿Seguro que quieres eliminar este usuario?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                    Eliminar
                                </button>
                            </form>
                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>

    </div>

</x-app-layout>