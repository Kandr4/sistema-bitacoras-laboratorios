<x-app-layout>

<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold">
            Bitácora de Mantenimiento
        </h2>

        <div class="flex gap-2">
            <!-- ➕ NUEVO -->
            <a href="{{ route('tecnico.mantenimiento.create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
               + Nuevo
            </a>

            <!-- 🔙 REGRESAR -->
            <a href="/tecnico"
               class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
               ⬅ Regresar
            </a>
        </div>
    </div>
</x-slot>

<div class="py-10">
<div class="max-w-7xl mx-auto">

<div class="bg-white shadow-xl rounded-2xl p-6">

<!-- MENSAJE -->
<!-- MENSAJE -->
@if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        <ul>
            @foreach($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<table class="min-w-full border rounded-lg overflow-hidden">

<thead class="bg-gray-100 text-gray-700">
<tr>
    <th class="p-3 text-left">Técnico</th>
    <th class="p-3 text-left">Laboratorio</th>
    <th class="p-3 text-left">Fecha</th>
    <th class="p-3 text-left">Total Equipos</th>
    <th class="p-3 text-left">Operativos</th>
    <th class="p-3 text-left">En reparación</th>
    <th class="p-3 text-left">Acciones</th>
</tr>
</thead>

<tbody>
@forelse($mantenimientos as $m)

<tr class="border-t hover:bg-gray-50">

    <td class="p-3">
        {{ $m->usuario->nombre ?? 'N/A' }}
    </td>

    <td class="p-3">
        {{ $m->laboratorio->nombre ?? 'N/A' }}
    </td>

    <td class="p-3">
        {{ $m->fechaHora }}
    </td>

    <td class="p-3">
        {{ $m->totalequipos }}
    </td>

    <td class="p-3 text-green-600 font-semibold">
        {{ $m->equiposoperativos }}
    </td>

    <td class="p-3 text-red-600 font-semibold">
        {{ $m->equiposreparacion }}
    </td>

    <td class="p-3">
        <div class="flex gap-2">

            <!-- EDITAR -->
            <a href="{{ route('tecnico.mantenimiento.edit', $m->idmantenimiento) }}"
               class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
               Editar
            </a>

            <!-- ELIMINAR -->
            <form action="{{ route('tecnico.mantenimiento.destroy', $m->idmantenimiento) }}" method="POST">
                @csrf
                @method('DELETE')

                <button type="submit"
                    onclick="return confirm('¿Eliminar este registro?')"
                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                    Eliminar
                </button>
            </form>

        </div>
    </td>

</tr>

@empty
<tr>
    <td colspan="7" class="text-center p-4 text-gray-500">
        No hay registros de mantenimiento
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