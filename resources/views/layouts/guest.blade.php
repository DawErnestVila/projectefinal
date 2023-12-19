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

    <style>
        body {
            background-image: url('{{ asset('images/login_background_done.webp') }}');
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            height: 100vh;
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased">

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 text-gray-300">
        <div>
            <a href="/" class="hover:text-gray-500 transition-colors duration-300">
                <h1 class="text-3xl font-black">Perruqueria Institut Cirviànum</h1>
            </a>
        </div>


        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white text-gray-900 shadow-md overflow-hidden sm:rounded-lg">

            {{ $slot }}
        </div>
        <span>
            Imatge de <a
                href="https://www.freepik.es/vector-gratis/papel-pintado-abstracto-blanco_12066076.htm#query=white%20geometric%20background&position=0&from_view=search&track=ais&uuid=271032b7-4b3a-4905-92f7-ce94831cbf96"
                class="text-white font-semibold">Freepik</a>
        </span>
    </div>
</body>

</html>
