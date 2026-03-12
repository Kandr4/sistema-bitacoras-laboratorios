<x-guest-layout>

<div class="min-h-screen w-full flex items-center justify-center bg-gradient-to-br from-blue-300 to-indigo-500">

    <!-- Tarjeta -->
    <div class="w-full max-w-lg bg-white shadow-2xl rounded-2xl px-12 py-14">

        <!-- Título -->
        <div class="text-center mb-10">

            <h1 class="text-3xl font-bold text-gray-800">
                Sistema de Bitácoras
            </h1>

            <p class="text-gray-500 mt-2">
                Registro de Usuario
            </p>

            <div class="w-16 h-1 bg-indigo-500 mx-auto mt-4 rounded"></div>

        </div>

        <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nombre -->
        <div class="mb-5">
            <x-input-label for="nombre" :value="__('Nombre')" />

            <x-text-input
                id="nombre"
                class="block mt-2 w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition"
                type="text"
                name="nombre"
                :value="old('nombre')"
                required
                autofocus
            />

            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <!-- Apellido paterno -->
        <div class="mb-5">
            <x-input-label for="paterno" :value="__('Apellido paterno')" />

            <x-text-input
                id="paterno"
                class="block mt-2 w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition"
                type="text"
                name="paterno"
                :value="old('paterno')"
                required
            />

            <x-input-error :messages="$errors->get('paterno')" class="mt-2" />
        </div>

        <!-- Apellido materno -->
        <div class="mb-5">
            <x-input-label for="materno" :value="__('Apellido materno')" />

            <x-text-input
                id="materno"
                class="block mt-2 w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition"
                type="text"
                name="materno"
                :value="old('materno')"
                required
            />

            <x-input-error :messages="$errors->get('materno')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mb-7">
            <x-input-label for="email" :value="__('Correo institucional')" />

            <x-text-input 
                id="email"
                class="block mt-2 w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition"
                type="email"
                name="email"
                :value="old('email')"
                required
            />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Contraseña -->
        <div class="mb-7">
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input
                id="password"
                class="block mt-2 w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition"
                type="password"
                name="password"
                required
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmar contraseña -->
        <div class="mb-7">
            <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />

            <x-text-input
                id="password_confirmation"
                class="block mt-2 w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition"
                type="password"
                name="password_confirmation"
                required
            />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Link login -->
        <div class="flex justify-between items-center mb-8 text-sm">

            <a class="text-indigo-600 hover:text-indigo-800 hover:underline" href="{{ route('login') }}">
                ¿Ya tienes cuenta?
            </a>

        </div>

        <!-- Botones -->
        <div class="flex gap-4">

            <!-- Cancelar -->
            <a href="/" 
               class="w-1/2 text-center py-3 text-lg border border-gray-300 rounded-lg hover:bg-gray-100 transition">
               Cancelar
            </a>

            <!-- Registrarse -->
            <x-primary-button class="w-1/2 justify-center py-3 text-lg bg-indigo-600 hover:bg-indigo-700 transition rounded-lg">
                Registrarse
            </x-primary-button>

        </div>

        </form>

    </div>

</div>

</x-guest-layout>