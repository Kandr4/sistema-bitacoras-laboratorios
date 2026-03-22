<x-app-layout>

<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="h4">Solicitud de Software</h2>

        <!-- 🔙 BOTÓN REGRESAR -->
        <a href="{{ url('/profesor') }}"
           class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition shadow">
            ⬅ Regresar
        </a>
    </div>
</x-slot>

<div class="container mt-4">

<form action="{{ route('profesor.solicitudes.store') }}" method="POST">
@csrf

<div class="mb-3">
    <label>Software requerido</label>
    <input type="text" name="software" class="form-control" required>
</div>

<div class="mb-3">
    <label>Laboratorio</label>
    <select name="idlab" class="form-control" required>
        @foreach($laboratorios as $lab)
            <option value="{{ $lab->idlab }}">{{ $lab->nombre }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Comentarios</label>
    <textarea name="comentario" class="form-control"></textarea>
</div>

<button class="btn btn-primary">
    Enviar solicitud
</button>

</form>

</div>

</x-app-layout>