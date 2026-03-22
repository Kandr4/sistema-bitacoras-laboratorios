<x-app-layout>

<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold">
            Editar Mantenimiento
        </h2>

        <a href="{{ route('tecnico.mantenimiento.index') }}"
           class="bg-gray-500 text-white px-4 py-2 rounded-lg">
           ⬅ Regresar
        </a>
    </div>
</x-slot>

<div class="py-10">
<div class="max-w-4xl mx-auto">

<div class="bg-white shadow-xl rounded-2xl p-6">

<form method="POST" action="{{ route('tecnico.mantenimiento.update', $mantenimiento->idmantenimiento) }}">
@csrf
@method('PUT')

<!-- LAB -->
<div class="mb-4">
    <label class="block font-semibold">Laboratorio</label>
    <select name="idlab" class="w-full border p-2 rounded">
        @foreach($laboratorios as $lab)
            <option value="{{ $lab->idlab }}"
                {{ $lab->idlab == $mantenimiento->idlab ? 'selected' : '' }}>
                {{ $lab->nombre }}
            </option>
        @endforeach
    </select>
</div>

<!-- CAMPOS -->
<div class="grid grid-cols-2 gap-4">

<input type="number" name="totalequipos"
    value="{{ $mantenimiento->totalequipos }}"
    class="border p-2 rounded">

<input type="number" name="equiposoperativos"
    value="{{ $mantenimiento->equiposoperativos }}"
    class="border p-2 rounded">

<input type="number" name="equiposreparacion"
    value="{{ $mantenimiento->equiposreparacion }}"
    class="border p-2 rounded">

<input type="number" name="preventivos"
    value="{{ $mantenimiento->preventivos }}"
    class="border p-2 rounded">

<input type="number" name="correctivos"
    value="{{ $mantenimiento->correctivos }}"
    class="border p-2 rounded">

<input type="number" name="reprogramados"
    value="{{ $mantenimiento->reprogramados }}"
    class="border p-2 rounded">

</div>

<!-- BOTÓN -->
<div class="mt-6">
    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        Actualizar
    </button>
</div>

</form>

</div>
</div>
</div>

</x-app-layout>