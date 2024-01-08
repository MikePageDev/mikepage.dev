<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>
    @vite('resources/css/app.css')
</head>
<body>
    <nav class="flex h-20">
        <a href="{{ route('home') }}" class="h-14 w-14 rounded-full border-2 border-white group shadow">
            <img src="{{ asset('img/mike.jpg') }}" alt="Mike Page" class="rounded-full group-hover:opacity-80 transition-all duration-150">
        </a>
    </nav>
    <main>
        {{ $slot }}
    </main>
</body>
</html>
