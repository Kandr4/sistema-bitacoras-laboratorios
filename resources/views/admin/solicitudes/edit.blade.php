<x-app-layout>

<x-slot name="header">
    <h2>Actualizar Solicitud</h2>
</x-slot>

<div class="p-6">

@php
    $updateRoute = Auth::user()->rol === 'Técnico' 
        ? route('tecnico.solicitudes.update', $solicitud->idsolSoftware) 
        : route('admin.solicitudes.update', $solicitud->idsolSoftware);
@endphp

<form method="POST" action="{{ $updateRoute }}">
@csrf
@method('PUT')

<label>Estado</label>
<select name="estado" class="border p-2 w-full mb-4">
    <option>Pendiente</option>
    <option>En proceso</option>
    <option>Instalado</option>
    <option>Rechazado</option>
</select>

<label>Observaciones técnicas</label>
<textarea name="comentario_tecnico" class="border w-full p-2"></textarea>

<button class="bg-blue-600 text-white px-4 py-2 rounded mt-4">
    Actualizar
</button>

</form>

</div>

</x-app-layout>