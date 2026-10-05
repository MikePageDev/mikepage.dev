@props([
    'title' => null,
    'description' => null,
])

@php
    $pageTitle = $title ? $title . ' | ' . config('app.name') : config('app.name');
    $pageDescription = $description ?? config('site.description');
    $navLinks = [
        'about' => 'About',
        'portfolio' => 'Portfolio',
        'contact' => 'Contact',
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ darkMode: localStorage.getItem('dark') === 'true', menuOpen: false }"
      x-init="$watch('darkMode', val => localStorage.setItem('dark', val))"
      x-bind:class="{ 'dark': darkMode }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset(config('site.og_image')) }}">
    <meta name="twitter:card" content="summary">
    <script>
        try {
            if (localStorage.getItem('dark') === 'true') {
                document.documentElement.classList.add('dark');
            }
        } catch (e) {}
    </script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="min-h-screen max-w-screen-lg mx-auto flex flex-col bg-white dark:bg-neutral-900 dark:text-white">
    <nav aria-label="Main" class="relative flex justify-between h-20 items-center px-5">
        <a href="{{ route('home') }}" class="h-14 w-14 rounded-full border-2 border-white dark:border-neutral-700 group shadow">
            <img src="{{ asset('img/mike.jpg') }}" alt="Mike Page" class="rounded-full group-hover:opacity-80 transition-all duration-150">
        </a>

        <ul class="hidden sm:flex w-1/2 mx-auto justify-around items-center">
            @foreach ($navLinks as $route => $label)
                <li class="mx-3 hover:text-neutral-600 dark:hover:text-neutral-400">
                    <a href="{{ route($route) }}" @if (request()->routeIs($route . '*')) aria-current="page" class="font-semibold" @endif>{{ $label }}</a>
                </li>
            @endforeach
        </ul>

        <button type="button"
                class="sm:hidden"
                x-on:click="menuOpen = !menuOpen"
                aria-controls="mobile-menu"
                aria-expanded="false"
                x-bind:aria-expanded="menuOpen.toString()">
            <span class="sr-only">Toggle menu</span>
            <x-heroicon-m-bars-3 x-show="!menuOpen" aria-hidden="true" class="h-8 stroke-gray-700 fill-gray-700 dark:stroke-gray-100 dark:fill-gray-100 cursor-pointer" />
            <x-heroicon-o-x-mark x-show="menuOpen" x-cloak aria-hidden="true" class="h-8 stroke-2 stroke-gray-700 fill-gray-700 dark:stroke-gray-100 dark:fill-gray-100" />
        </button>
        <div id="mobile-menu" x-show="menuOpen" x-cloak class="absolute sm:hidden top-20 left-0 z-10 shadow w-full text-center text-lg pb-3 bg-white dark:bg-neutral-900">
            <ul class="flex flex-col gap-y-3">
                @foreach ($navLinks as $route => $label)
                    <li class="mx-3 hover:text-neutral-600 dark:hover:text-neutral-400">
                        <a href="{{ route($route) }}" @if (request()->routeIs($route . '*')) aria-current="page" class="font-semibold" @endif>{{ $label }}</a>
                    </li>
                @endforeach
            </ul>
        </div>

        <button type="button" x-on:click="darkMode = !darkMode" aria-label="Toggle dark mode" x-bind:aria-pressed="darkMode.toString()">
            <x-heroicon-s-moon x-show="!darkMode" x-cloak aria-hidden="true" class="p-2 ml-3 w-8 h-8 text-gray-700 bg-neutral-100 rounded-md transition cursor-pointer hover:bg-neutral-200" />
            <x-heroicon-s-sun x-show="darkMode" x-cloak aria-hidden="true" class="p-2 ml-3 w-8 h-8 text-gray-100 bg-neutral-700 rounded-md transition cursor-pointer dark:hover:bg-neutral-600" />
        </button>
    </nav>
    <main class="flex flex-1 flex-col px-5">
        {{ $slot }}
    </main>
    <footer class="flex flex-col items-center py-5 px-5 text-center">
        <div id="socials" class="pb-3">
            <x-social-links />
        </div>
        <div class="text-sm text-neutral-500">
            <p>This site has been developed by Mike Page, and is <a href="https://github.com/MikePageDev/mikepage.dev" class="underline hover:text-neutral-400">open source</a></p>
        </div>
    </footer>
</body>

</html>
