<x-guest-layout>

<div class="min-h-screen w-full flex items-center justify-center bg-gradient-to-br from-blue-300 to-indigo-500">

    <!-- Tarjeta del login -->
    <div class="w-full max-w-lg bg-white shadow-2xl rounded-2xl px-12 py-14">

        <!-- Título -->
        <div class="text-center mb-10">

            <h1 class="text-3xl font-bold text-gray-800">
                Sistema de Bitácoras
            </h1>

            <p class="text-gray-500 mt-2">
                Laboratorio de Cómputo
            </p>

            <div class="w-16 h-1 bg-indigo-500 mx-auto mt-4 rounded"></div>

        </div>

        <x-auth-session-status class="mb-6" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
        @csrf

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
            autofocus
            />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
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

        <!-- Remember & Forgot -->
        <div class="flex justify-between items-center mb-8 text-sm">
            <label class="flex items-center text-gray-600">
                <input type="checkbox" name="remember" class="mr-2 rounded border-gray-300">
                Recordarme
            </label>

            @if (Route::has('password.request'))
            <a class="text-indigo-600 hover:text-indigo-800 hover:underline" href="{{ route('password.request') }}">
                ¿Olvidaste tu contraseña?
            </a>
            @endif
        </div>

        <!-- Botones -->
        <div class="flex gap-4 mb-4">
            <!-- Cancelar -->
            <a href="/" 
               class="w-1/2 text-center py-3 text-lg border border-gray-300 rounded-lg hover:bg-gray-100 transition">
               Cancelar
            </a>

            <!-- Iniciar sesión -->
            <x-primary-button class="w-1/2 justify-center py-3 text-lg bg-indigo-600 hover:bg-indigo-700 transition rounded-lg">
                Iniciar sesión
            </x-primary-button>
        </div>

        </form>

        <!-- Botón de Registrarse -->
        <div class="text-center mt-4">
            <a href="{{ route('register') }}" 
               class="text-indigo-600 font-semibold hover:text-indigo-800 hover:underline">
               ¿No tienes cuenta? Regístrate
            </a>
        </div>

    </div>

</div>

</x-guest-layout>