<x-app-layout>
    <div class="p-8 max-w-md mx-auto bg-white shadow rounded">
        <h1 class="text-2xl font-bold mb-6">Editar Usuario</h1>

        <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nombre (solo lectura) -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Nombre</label>
                <input type="text" value="{{ $usuario->nombre }} {{ $usuario->paterno }}" disabled class="w-full border px-3 py-2 rounded bg-gray-100">
            </div>

            <!-- Correo (solo lectura) -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Correo</label>
                <input type="email" value="{{ $usuario->email }}" disabled class="w-full border px-3 py-2 rounded bg-gray-100">
            </div>

            <!-- Rol -->
            <div class="mb-4">
                <label class="block font-semibold mb-1">Rol</label>
                <select name="rol" class="w-full border px-3 py-2 rounded">
                    <option value="Admin" {{ $usuario->rol == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Profesor" {{ $usuario->rol == 'Profesor' ? 'selected' : '' }}>Profesor</option>
                    <option value="Técnico" {{ $usuario->rol == 'Técnico' ? 'selected' : '' }}>Técnico</option>
                </select>
            </div>

            <!-- Estado -->
            <div class="mb-6">
                <label class="block font-semibold mb-1">Estado</label>
                <select name="estado" class="w-full border px-3 py-2 rounded">
                    <option value="1" {{ $usuario->estado ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ !$usuario->estado ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <!-- Botones Guardar y Cancelar -->
            <div class="flex justify-between">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Guardar
                </button>

                <a href="{{ route('usuarios.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                    Cancelar
                </a>
            </div>

        </form>
    </div>
</x-app-layout>