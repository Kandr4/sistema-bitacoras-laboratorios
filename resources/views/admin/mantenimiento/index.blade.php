<x-app-layout>

<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold">
            Bitácoras de Mantenimiento
        </h2>

        <a href="/admin"
           class="bg-gray-500 text-white px-4 py-2 rounded-lg">
           ⬅ Regresar
        </a>
    </div>
</x-slot>

<div class="py-10">
<div class="max-w-7xl mx-auto">

<div class="bg-white shadow-xl rounded-2xl p-6">

<!-- 🔍 FILTROS -->
<form method="GET" class="grid grid-cols-5 gap-4 mb-6">

    <!-- LAB -->
    <select name="idlab" class="border p-2 rounded">
        <option value="">Laboratorio</option>
        @foreach($laboratorios as $lab)
            <option value="{{ $lab->idlab }}">
                {{ $lab->nombre }}
            </option>
        @endforeach
    </select>

    <!-- TECNICO -->
    <input type="text" name="tecnico" placeholder="Técnico"
        class="border p-2 rounded">

    <!-- FECHA -->
    <input type="date" name="fecha" class="border p-2 rounded">

    <!-- ESTADO -->
    <select name="estado" class="border p-2 rounded">
        <option value="">Estado equipo</option>
        <option value="operativo">Operativo</option>
        <option value="reparacion">En reparación</option>
    </select>

    <!-- BOTÓN -->
    <button class="bg-blue-600 text-white rounded px-4">
        Filtrar
    </button>

</form>

<!-- 📊 TABLA -->
<table class="w-full border rounded-lg">

<thead class="bg-gray-100">
<tr>
    <th class="p-2">Técnico</th>
    <th class="p-2">Laboratorio</th>
    <th class="p-2">Fecha</th>
    <th class="p-2">Total</th>
    <th class="p-2">Operativos</th>
    <th class="p-2">Reparación</th>
    <th>Última modificación</th>
    <th>Modificado por</th>
</tr>
</thead>

<tbody>
@foreach($mantenimientos as $m)
<tr class="border-t">
    <td class="p-2">{{ $m->usuario->nombre ?? 'N/A' }}</td>
    <td class="p-2">{{ $m->laboratorio->nombre ?? 'N/A' }}</td>
    <td class="p-2">{{ $m->fechaHora }}</td>
    <td class="p-2">{{ $m->totalequipos }}</td>
    <td class="p-2 text-green-600">{{ $m->equiposoperativos }}</td>
    <td class="p-2 text-red-600">{{ $m->equiposreparacion }}</td>
    <td>{{ $m->updated_at }}</td>
<td>{{ $m->usuario->nombre ?? 'N/A' }}</td>
</tr>
@endforeach
</tbody>

</table>

</div>
</div>
</div>

</x-app-layout>