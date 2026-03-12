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

<body class="bg-gray-100 text-gray-800 flex flex-col items-center min-h-screen p-6">

    <!-- HEADER -->
    <header class="w-full max-w-4xl flex justify-end mb-6">

        
    </header>

    <!-- HERO -->
    <main class="text-center max-w-3xl">

        <h1 class="text-4xl font-bold mb-4">
            Sistema de Bitácoras
        </h1>

        <p class="text-gray-600 mb-8">
            Plataforma para registrar y gestionar las actividades del laboratorio de cómputo.
            Permite administrar usuarios, registrar incidencias y consultar reportes.
        </p>

        <div class="flex justify-center gap-4">

            <a href="{{ route('login') }}"
                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Iniciar sesión
            </a>

            <a href="{{ route('register') }}"
                class="px-6 py-3 border border-gray-400 rounded-lg hover:bg-gray-200 transition">
                Registrarse
            </a>

        </div>

    </main>

    <!-- CARACTERÍSTICAS -->
    <section class="max-w-5xl mt-16 grid md:grid-cols-3 gap-6 text-center">

        <div class="p-6 bg-white rounded-xl shadow">

            <h3 class="text-xl font-semibold mb-2">
                Registro de Bitácoras
            </h3>

            <p class="text-gray-500">
                Permite registrar actividades realizadas en el laboratorio.
            </p>

        </div>

        <div class="p-6 bg-white rounded-xl shadow">

            <h3 class="text-xl font-semibold mb-2">
                Gestión de Usuarios
            </h3>

            <p class="text-gray-500">
                Administra los usuarios que utilizan el sistema.
            </p>

        </div>

        <div class="p-6 bg-white rounded-xl shadow">

            <h3 class="text-xl font-semibold mb-2">
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