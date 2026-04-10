<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Oefen-examen</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100 text-gray-900 flex items-center justify-center min-h-screen">
    <div class="max-w-xl w-full text-center bg-white shadow-xl rounded-2xl p-8 border border-gray-100">
        <h1 class="text-4xl font-extrabold mb-4 text-indigo-600">Welkom!</h1>
        <p class="mb-8 text-gray-500 text-lg">Dit Oefen-examen project is ingericht met Laravel Breeze authenticatie, TailwindCSS en een rollensysteem.</p>

        @if (Route::has('login'))
            <div class="space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="inline-block font-bold text-white bg-indigo-600 hover:bg-indigo-700 px-6 py-3 rounded-lg shadow transition-colors">Ga naar Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="inline-block font-semibold text-indigo-600 hover:text-white hover:bg-indigo-600 px-6 py-3 border-2 border-indigo-600 rounded-lg shadow-sm transition-colors">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="inline-block font-semibold text-gray-700 hover:text-white hover:bg-gray-800 px-6 py-3 border-2 border-gray-800 rounded-lg shadow-sm transition-colors">Registreer</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</body>
</html>
