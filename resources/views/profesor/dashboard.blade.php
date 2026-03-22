<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard Profesor
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <h4>Bienvenido {{ Auth::user()->name }}</h4>

                <p>Tu rol es: <b>{{ Auth::user()->rol }}</b></p>

                <hr>

                <div class="d-flex gap-3">

                    <a href="{{ route('profesor.solicitudes.create') }}" class="btn btn-primary">
                        📥 Solicitar Software
                    </a>

                    <!-- FUTURO -->
                    <a href="{{ route('profesor.solicitudes.index') }}" class="btn btn-outline-secondary">
                        📄 Ver mis solicitudes
                    </a>
                    <a href="{{ route('profesor.fallas.index') }}" class="btn btn-outline-secondary">
                        Reportar fallas
                    </a>

                </div>

            </div>
        </div>

    </div>
</div>

</x-app-layout>