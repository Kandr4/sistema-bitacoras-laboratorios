<x-app-layout>

<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold">
            Registrar Mantenimiento
        </h2>

        <!-- 🔙 REGRESAR -->
        <a href="/tecnico"
           class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
           ⬅ Regresar
        </a>
    </div>
</x-slot>

<div class="py-10">
<div class="max-w-5xl mx-auto">

<div class="bg-white shadow-xl rounded-2xl p-6">

<form action="{{ route('tecnico.mantenimiento.store') }}" method="POST">
@csrf

<!-- LABORATORIO -->
<div class="mb-4">
    <label class="block font-semibold mb-1">Laboratorio</label>
    <select name="idlab" class="w-full border rounded-lg p-2" required>
        @foreach($laboratorios as $lab)
            <option value="{{ $lab->idlab }}">{{ $lab->nombre }}</option>
        @endforeach
    </select>
</div>

<!-- GRID -->
<div class="grid grid-cols-2 gap-4">

    <input type="number" name="totalequipos" placeholder="Total equipos"
        class="border rounded-lg p-2">

    <input type="number" name="equiposoperativos" placeholder="Equipos operativos"
        class="border rounded-lg p-2">

    <input type="number" name="equiposreparacion" placeholder="Equipos en reparación"
        class="border rounded-lg p-2">

    <input type="number" name="preventivos" placeholder="Mantenimientos preventivos"
        class="border rounded-lg p-2">

    <input type="number" name="correctivos" placeholder="Mantenimientos correctivos"
        class="border rounded-lg p-2">

    <input type="number" name="reprogramados" placeholder="Reprogramados"
        class="border rounded-lg p-2">

</div>

<!-- BOTÓN -->
<div class="mt-6">
    <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
        Guardar mantenimiento
    </button>
</div>

</form>

</div>
</div>
</div>

</x-app-layout>