<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Bienvenida --}}
                    <h1 class="text-2xl font-bold mb-2">Bienvenido {{ Auth::user()->name }}</h1>
                    <p class="mb-6">Tu rol es: <b>{{ ucfirst(Auth::user()->rol) }}</b></p>

                    {{-- Botones de gestión --}}
                    <div class="flex flex-wrap gap-4">

                        {{-- Botón Gestionar Usuarios --}}
                        <a href="{{ route('usuarios.index') }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                            Gestionar Usuarios
                        </a>

                        {{-- Ejemplo de otros botones de gestión --}}
                        <a href="#" 
                           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                            Otro Botón
                        </a>

                        <a href="#" 
                           class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
                            Más Opciones
                        </a>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>