<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistema de Bitácoras</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body{
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg,#4f46e5,#6366f1);
            min-height:100vh;
        }

        .main-card{
            background:white;
            border-radius:15px;
            box-shadow:0 10px 30px rgba(0,0,0,0.2);
        }

        .header-title{
            font-weight:600;
            color:#374151;
        }
    </style>

</head>

<body>

    <!-- NAVBAR -->
    @include('layouts.navigation')

    <div class="container py-5">

        <!-- HEADER -->
        @isset($header)

        <div class="main-card mb-4 p-4">

            <h2 class="header-title">
                {{ $header }}
            </h2>

        </div>

        @endisset

        <!-- CONTENIDO -->
        <div class="main-card p-4">

            <main>
                {{ $slot }}
            </main>

        </div>

    </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>