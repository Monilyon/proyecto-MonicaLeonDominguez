<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Admin</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .btn-mockup {
            background-color: #f1efed;
            color: #1a1a1a;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            border: 1px solid #e2e0de;
            transition: all 0.3s;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 24px;
            white-space: nowrap;
        }
        .btn-mockup:hover {
            background-color: #e5e3e1;
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen bg-[#f3f4f1] p-6 md:p-10">

    <div class="grid grid-cols-1 md:grid-cols-2 items-center bg-white border border-gray-200 rounded-[40px] md:rounded-[50px] p-8 md:p-16 max-w-6xl w-full gap-12 md:gap-16 shadow-sm">

        <div class="flex justify-center w-full">
            <img src="{{ asset('logo panel admin.png') }}" alt="Logo" class="w-full max-w-[280px] md:max-w-md h-auto block">
        </div>

        <div class="flex flex-col items-center md:items-start text-center md:text-left w-full">

            <h2 class="text-3xl md:text-4xl font-bold text-black mb-4 leading-tight">
                Bienvenido al panel de administración
            </h2>

            <p class="text-gray-600 text-lg md:text-xl mb-8">
                Aquí podrás gestionar actividades de ocio, deportes, cultura y acción social con las herramientas oficiales de nuestra plataforma.
            </p>

            <div class="flex flex-row md:flex-row items-stretch md:items-start gap-3 w-full md:w-auto">
                <a href="{{ url('/dashboard') }}" class="btn-mockup w-full md:w-auto">
                    Ver eventos
                </a>
                <a href="{{ url('/events/create') }}" class="btn-mockup w-full md:w-auto">
                    Crear eventos
                </a>
            </div>

        </div>

    </div>

</body>
</html>
