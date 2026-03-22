<x-app-layout>
    <x-slot name="header">
        
         <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Equipos
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.equipos.create') }}" 
                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition flex items-center gap-1">
                    Nuevo Equipo
                </a>
                <a href="/admin"
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition flex items-center gap-1">
                ⬅ Regresar
                </a>
            </div>
            


         </div>

    </x-slot>

    <div class="py-6 max-w-7xl mx-auto space-y-6">

        <div class="bg-white shadow rounded-lg overflow-x-auto mt-4">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr class="text-left text-sm font-semibold text-gray-700">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Laboratorio</th>
                        <th class="px-4 py-2">Descripción</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($equipos as $equipo)
                        <tr>
                            <td class="px-4 py-2">{{ $equipo->id }}</td>
                            <td class="px-4 py-2">{{ $equipo->nombre }}</td>
                            <td class="px-4 py-2">{{ $equipo->laboratorio->nombre ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $equipo->descripcion }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ route('admin.equipos.edit', $equipo) }}" class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Editar</a>

                                <form action="{{ route('admin.equipos.destroy', $equipo) }}" method="POST" onsubmit="return confirm('¿Eliminar este equipo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="p-4">
                {{ $equipos->links() }}
            </div>
        </div>
    </div>
</x-app-layout>