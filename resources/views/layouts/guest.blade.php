<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-[#31304D]" style="opacity: 0.9;">
    <div class="absolute inset-0 z-[-1]"
        style="background-image: url('{{ asset('https://img.freepik.com/vector-gratis/papel-pintado-abstracto-blanco_23-2148817745.jpg?w=1380&t=st=1702839204~exp=1702839804~hmac=273ffdee52fd1b9d2a2e52e2a17cd56f82fc818d162992712046db8cb9271e8b') }}');
           background-size: cover;
           background-repeat: no-repeat;
           opacity: 0.2;">
    </div>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 text-gray-300">
        <div>
            <a href="/" class="hover:text-gray-500 transition-colors duration-300">
                <h1 class="text-3xl font-black">Perruqueria Institut Cirviànum</h1>
            </a>
        </div>


        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white text-gray-900 shadow-md overflow-hidden sm:rounded-lg">

            {{ $slot }}
        </div>
    </div>
</body>

</html>
