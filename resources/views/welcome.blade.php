<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Sistema de Bitácoras') }}</title>

    <!-- Fuente -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet">

    <!-- Tailwind / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-gray-100 to-blue-100 text-gray-800 flex flex-col items-center min-h-screen p-6">
    <!-- HEADER -->
    <header class="w-full bg-gradient-to-r from-blue-700 to-indigo-800 shadow-lg">

    <div class="max-w-7xl mx-auto px-6">

        <div class="flex justify-between items-center h-16">

            <!-- Logo + nombre -->
            <div class="flex items-center gap-3">

                <div class="bg-white text-blue-700 p-2 rounded-lg shadow">
                    
                </div>

                <div class="text-white">

                    <h1 class="font-bold text-lg leading-none">
                        Sistema de Bitácoras
                    </h1>

                    <p class="text-xs text-blue-200">
                        Laboratorio de Cómputo
                    </p>

                </div>

            </div>

            
        </div>

    </div>

</header>

    <!-- HERO -->
    <main class="text-center max-w-4xl mx-auto mt-16">

    <div class="bg-white p-12 rounded-2xl shadow-xl">

        <h1 class="text-5xl font-bold mb-6 text-gray-800">
            Sistema de Bitácoras de Laboratorio
        </h1>

        <p class="text-lg text-gray-600 mb-10 leading-relaxed">
            Plataforma institucional para registrar, controlar y administrar
            las actividades realizadas en el laboratorio de cómputo.
            Permite gestionar usuarios, registrar incidencias
            y generar reportes del sistema.
        </p>

        <div class="flex justify-center gap-6">

            @auth
                @if(in_array(Auth::user()->rol, ['Admin', 'Profesor', 'Técnico']))
                    {{-- Usuario con rol: ir a su panel --}}
                    <a href="{{ route('dashboard') }}"
                        class="px-10 py-4 bg-blue-600 text-white rounded-xl shadow-lg 
                        hover:bg-blue-700 hover:scale-105 transition duration-300">
                        Ir a mi panel
                    </a>
                @else
                    {{-- Usuario sin rol: mensaje de espera --}}
                    <div class="w-full">
                        <div class="bg-yellow-50 border border-yellow-300 rounded-xl p-6 text-center">
                            <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-yellow-100 mb-4">
                                <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-yellow-800 mb-2">
                                ¡Cuenta registrada exitosamente!
                            </h3>
                            <p class="text-yellow-700 text-sm mb-4">
                                Un administrador debe asignarte un rol para que puedas acceder al sistema.
                                Por favor, espera a que se te asigne tu rol.
                            </p>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="px-8 py-3 bg-gray-600 text-white rounded-xl shadow
                                    hover:bg-gray-700 hover:scale-105 transition duration-300">
                                    Cerrar sesión
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @else
                {{-- No autenticado: botones normales --}}
                <a href="{{ route('login') }}"
                    class="px-10 py-4 bg-blue-600 text-white rounded-xl shadow-lg 
                    hover:bg-blue-700 hover:scale-105 transition duration-300">
                    Iniciar sesión
                </a>

                <a href="{{ route('register') }}"
                    class="px-10 py-4 border-2 border-blue-600 text-blue-600 
                    rounded-xl hover:bg-blue-600 hover:text-white 
                    transition duration-300">
                    Registrarse
                </a>
            @endauth

        </div>

    </div>

</main>

<section class="max-w-6xl mt-20 grid md:grid-cols-3 gap-8 text-center">

    <div class="p-8 bg-white rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-2 transition">

        <h3 class="text-xl font-semibold mb-3">
            Registro de Bitácoras
        </h3>

        <p class="text-gray-500">
            Permite registrar actividades realizadas en el laboratorio.
        </p>

    </div>

    <div class="p-8 bg-white rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-2 transition">

        <h3 class="text-xl font-semibold mb-3">
             Gestión de Usuarios
        </h3>

        <p class="text-gray-500">
            Administra los usuarios que utilizan el sistema.
        </p>

    </div>

    <div class="p-8 bg-white rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-2 transition">

        <h3 class="text-xl font-semibold mb-3">
            Reportes
        </h3>

        <p class="text-gray-500">
            Consulta reportes y estadísticas del sistema.
        </p>

    </div>

</section>

    <!-- FOOTER -->
    <footer class="mt-16 text-sm text-gray-500 text-center">

        <p>
            © {{ date('Y') }} Sistema de Bitácoras - Laboratorio de Cómputo
        </p>

    </footer>

</body>

</html>