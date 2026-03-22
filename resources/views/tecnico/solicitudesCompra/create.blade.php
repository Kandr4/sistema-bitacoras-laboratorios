<x-app-layout>

<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold">
            Registrar Solicitud de Compra
        </h2>

        <a href="{{ route('tecnico.solicitudesCompra.index') }}"
           class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
           ⬅ Regresar
        </a>
    </div>
</x-slot>

<div class="py-10">
<div class="max-w-5xl mx-auto">

<div class="bg-white shadow-xl rounded-2xl p-6">

<form method="POST" action="{{ route('tecnico.solicitudesCompra.store') }}" enctype="multipart/form-data">
@csrf

<!-- GRID -->
<div class="grid grid-cols-2 gap-4">

    <input type="number" name="cantidad" placeholder="Cantidad"
        class="border rounded-lg p-2" required>

    <input type="number" step="0.01" name="costo_unitario" placeholder="Costo unitario"
        class="border rounded-lg p-2" required>

</div>

<!-- DESCRIPCIÓN -->
<div class="mt-4">
    <input type="text" name="descripcion" placeholder="Descripción"
        class="w-full border rounded-lg p-2" required>
</div>

<!-- CARACTERÍSTICAS -->
<div class="mt-4">
    <textarea name="caracteristicas" placeholder="Características técnicas"
        class="w-full border rounded-lg p-2" rows="3" required></textarea>
</div>

<!-- JUSTIFICACIÓN -->
<div class="mt-4">
    <textarea name="justificacion" placeholder="Justificación"
        class="w-full border rounded-lg p-2" rows="3" required></textarea>
</div>

<!-- LABORATORIO -->
<div class="mt-4">
    <label class="block font-semibold mb-1">Laboratorio</label>
    <select name="laboratorio_id" class="w-full border rounded-lg p-2" required>
        @foreach($laboratorios as $lab)
            <option value="{{ $lab->idlab }}">{{ $lab->nombre }}</option>
        @endforeach
    </select>
</div>

<!-- IMAGEN -->
<div class="mt-4">
    <input type="file" name="imagen"
        class="w-full border rounded-lg p-2">
</div>

<!-- BOTÓN -->
<div class="mt-6">
    <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
        Guardar solicitud
    </button>
</div>

</form>

</div>
</div>
</div>

</x-app-layout>