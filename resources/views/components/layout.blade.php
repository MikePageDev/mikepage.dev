<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-cloak
      x-data="{darkMode: localStorage.getItem('dark') === 'true'}"
      x-init="$watch('darkMode', val => localStorage.setItem('dark', val))"
      x-bind:class="{'dark': darkMode}"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="max-w-screen-lg mx-auto bg-white dark:bg-slate-500">
    <nav class="flex h-20">
        <a href="{'{ route('home') }}" class="h-14 w-14 rounded-full border-2 border-white group shadow">
            <img src="{{ asset('img/mike.jpg') }}" alt="Mike Page" class="rounded-full group-hover:opacity-80 transition-all duration-150">
        </a>

        <ul class="flex w-1/2 mx-auto justify-around items-center">
            <li class="mx-3">
                <a href="{{ route('about') }}">About</a>
            </li>
            <li class="mx-3">
                <a href="{{ route('portfolio') }}">Portfolio</a>
            </li>
            <li class="mx-3">
                <a href="{{ route('contact') }}">Contact</a>
            </li>
        </ul>
        <button x-cloak x-on:click="darkMode = !darkMode;">
            <x-heroicon-s-moon x-show="!darkMode" class="p-2 ml-3 w-8 h-8 text-gray-700 bg-gray-100 rounded-md transition cursor-pointer hover:bg-gray-200" />
            <x-heroicon-s-sun x-show="darkMode" class="p-2 ml-3 w-8 h-8 text-gray-100 bg-gray-700 rounded-md transition cursor-pointer dark:hover:bg-gray-600" />
        </button>
    </nav>
    <main>
        {{ $slot }}
    </main>
</body>
</html>
