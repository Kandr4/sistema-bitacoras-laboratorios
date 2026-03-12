<x-guest-layout>

<div class="min-h-screen w-full flex items-center justify-center bg-gradient-to-br from-blue-300 to-indigo-500">

    <!-- Tarjeta del formulario -->
    <div class="w-full max-w-lg bg-white shadow-2xl rounded-2xl px-12 py-14">

        <!-- Título -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-800">
                Recuperar Contraseña
            </h1>

            <p class="text-gray-500 mt-2">
                Ingresa tu correo y te enviaremos un enlace para restablecerla
            </p>

            <div class="w-16 h-1 bg-indigo-500 mx-auto mt-4 rounded"></div>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-6" :status="session('status')" />

        <!-- Formulario -->
        <form method="POST" action="{{ route('password.email') }}">
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
                    placeholder="correo@ejemplo.com"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Botones -->
            <div class="flex gap-4">
                <!-- Cancelar -->
                <a href="{{ route('login') }}" 
                   class="w-1/2 text-center py-3 text-lg border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                   Cancelar
                </a>

                <!-- Enviar enlace -->
                <x-primary-button class="w-1/2 justify-center py-3 text-lg bg-indigo-600 hover:bg-indigo-700 transition rounded-lg">
                    Enviar Enlace
                </x-primary-button>
            </div>

        </form>

    </div>

</div>

</x-guest-layout>