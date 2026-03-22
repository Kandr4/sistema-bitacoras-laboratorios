<x-app-layout>

<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold">
            Todas las Solicitudes de Software
        </h2>

        <!-- 🔙 BOTÓN REGRESAR -->
        @php
            $rutaRegresar = match(Auth::user()->rol) {
                'Admin' => url('/admin'),
                'Técnico' => url('/tecnico'),
                'Profesor' => url('/profesor'),
                default => url('/')
            };
        @endphp
        <a href="{{ $rutaRegresar }}"
            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition shadow">
            ⬅ Regresar
        </a>
    </div>
</x-slot>

<div class="py-10">
<div class="max-w-7xl mx-auto">

<div class="bg-white shadow-xl rounded-2xl p-6">

    <!-- MENSAJE -->
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="mb-4 flex gap-2">

        <input type="text" name="docente" placeholder="Buscar docente"
            class="border px-3 py-1 rounded">

        <select name="estado" class="border px-3 py-1 rounded">
            <option value="">Estado</option>
            <option>Pendiente</option>
            <option>En proceso</option>
            <option>Instalado</option>
            <option>Rechazado</option>
        </select>

        <input type="date" name="fecha" class="border px-3 py-1 rounded">

        <button class="bg-blue-600 text-white px-3 py-1 rounded">
            Filtrar
        </button>

    </form>

<table class="w-full border rounded-lg overflow-hidden">

<thead class="bg-gray-100 text-gray-700">
<tr>
    <th class="p-3 text-left">Docente</th>
    <th class="p-3 text-left">Software</th>
    <th class="p-3 text-left">Laboratorio</th>
    <th class="p-3 text-left">Estado</th>
    <th class="p-3 text-center">Acciones</th>
</tr>
</thead>

<tbody>
@foreach($solicitudes as $sol)

<tr class="border-t hover:bg-gray-50">

    <td class="p-3">
        {{ $sol->usuario->nombre ?? 'Sin usuario' }}
        {{ $sol->usuario->paterno ?? '' }}
    </td>
    <td class="p-3">{{ $sol->software }}</td>
    <td class="p-3">{{ $sol->laboratorio->nombre }}</td>

    <td class="p-3">
        <span class="font-semibold text-yellow-600">
            {{ $sol->estado }}
        </span>
    </td>

    <!-- 🔥 BOTONES BIEN ACOMODADOS -->
    <td class="p-3">
        <div class="flex justify-center gap-2">

            <!-- EDITAR -->
            <a href="{{ route('admin.solicitudes.edit', ['id' => $sol->idsolSoftware]) }}"
                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                Editar
            </a>

            <!-- ELIMINAR -->
            @if(Auth::user()->rol == 'Admin')
            <form action="{{ route('admin.solicitudes.destroy', ['id' => $sol->idsolSoftware]) }}" method="POST">
                @csrf
                @method('DELETE')

                <button type="submit"
                    onclick="return confirm('¿Eliminar esta solicitud?')"
                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">
                    Eliminar
                </button>
            </form>
            @endif

        </div>
    </td>

</tr>

@endforeach
</tbody>

</table>

</div>
</div>
</div>

</x-app-layout>