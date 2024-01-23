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
<body class="min-h-screen max-w-screen-lg mx-auto flex flex-col bg-white dark:bg-neutral-900 dark:text-white">
    <nav class="flex h-20 items-center">
        <a href="{'{ route('home') }}" class="h-14 w-14 rounded-full border-2 border-white dark:border-neutral-700 group shadow">
            <img src="{{ asset('img/mike.jpg') }}" alt="Mike Page" class="rounded-full group-hover:opacity-80 transition-all duration-150">
        </a>

        <ul class="flex w-1/2 mx-auto justify-around items-center">
            <li class="mx-3 hover:text-neutral-600 dark:hover:text-neutral-400">
                <a href="{{ route('about') }}">About</a>
            </li>
            <li class="mx-3 hover:text-neutral-600 dark:hover:text-neutral-400">
                <a href="{{ route('portfolio') }}">Portfolio</a>
            </li>
            <li class="mx-3 hover:text-neutral-600 dark:hover:text-neutral-400">
                <a href="{{ route('contact') }}">Contact</a>
            </li>
        </ul>
        <button x-cloak x-on:click="darkMode = !darkMode;">
            <x-heroicon-s-moon x-show="!darkMode" class="p-2 ml-3 w-8 h-8 text-gray-700 bg-neutral-100 rounded-md transition cursor-pointer hover:bg-neutral-200" />
            <x-heroicon-s-sun x-show="darkMode" class="p-2 ml-3 w-8 h-8 text-gray-100 bg-neutral-700 rounded-md transition cursor-pointer dark:hover:bg-neutral-600" />
        </button>
    </nav>
    <main class="flex flex-1 flex-col">
        {{ $slot }}
    </main>
    <footer class="flex flex-col items-center py-5">
        <div id="socials" class="pb-3">
            <ul class="flex gap-4">
                <li>
                    <a href="https://github.com/MikePageDev" class="text-neutral-500 hover:text-neutral-400">
                        <svg role="img" aria-label="GitHub" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 1.99994C6.475 1.99994 2 6.58794 2 12.2529C2 16.7899 4.862 20.6219 8.838 21.9799C9.338 22.0699 9.525 21.7619 9.525 21.4929C9.525 21.2499 9.512 20.4429 9.512 19.5829C7 20.0589 6.35 18.9569 6.15 18.3799C6.037 18.0849 5.55 17.1749 5.125 16.9319C4.775 16.7399 4.275 16.2649 5.112 16.2519C5.9 16.2399 6.462 16.9959 6.65 17.3029C7.55 18.8539 8.988 18.4189 9.562 18.1489C9.65 17.4829 9.912 17.0339 10.2 16.7779C7.975 16.5219 5.65 15.6379 5.65 11.7159C5.65 10.6009 6.037 9.67794 6.675 8.95994C6.575 8.70394 6.225 7.65294 6.775 6.24294C6.775 6.24294 7.612 5.97394 9.525 7.29394C10.325 7.06394 11.175 6.94794 12.025 6.94794C12.875 6.94794 13.725 7.06294 14.525 7.29394C16.437 5.96094 17.275 6.24394 17.275 6.24394C17.825 7.65294 17.475 8.70394 17.375 8.95994C18.012 9.67794 18.4 10.5879 18.4 11.7159C18.4 15.6499 16.063 16.5219 13.838 16.7779C14.2 17.0979 14.513 17.7139 14.513 18.6749C14.513 20.0459 14.5 21.1479 14.5 21.4949C14.5 21.7629 14.688 22.0839 15.188 21.9809C17.1849 21.2849 18.911 19.976 20.12 18.2409C21.3456 16.4848 22.0019 14.3945 22 12.2529C22 6.58794 17.525 1.99994 12 1.99994Z"/>
                        </svg>
                    </a>
                </li>

                <li>
                    <a href="https://phpc.social/@MikePageDev" class="text-neutral-500 hover:text-neutral-400">
                        <svg role="img" aria-label="Mastodon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.9873 17.2441C18.5074 16.9441 20.6999 15.4003 20.9749 13.9903C21.4099 11.7677 21.3749 8.56641 21.3749 8.56641C21.3749 4.22881 18.5174 2.95627 18.5174 2.95627C17.0773 2.29751 14.6035 2.02125 12.0335 2H11.971C9.39964 2.02125 6.92708 2.29751 5.48704 2.95627C5.48704 2.95627 2.63072 4.22755 2.63072 8.56641L2.62822 9.39393C2.62322 10.194 2.61947 11.0815 2.64197 12.0077C2.74572 16.2504 3.42449 20.433 7.36709 21.4705C9.18463 21.9492 10.7459 22.0492 12.0035 21.9805C14.2823 21.8555 15.5623 21.1717 15.5623 21.1717L15.4873 19.5254C15.4873 19.5254 13.8585 20.0379 12.0285 19.9754C10.2159 19.9129 8.30336 19.7804 8.0096 17.5654C7.98164 17.3599 7.96786 17.1527 7.96835 16.9454C7.96835 16.9454 9.7484 17.3779 12.0035 17.4804C13.3822 17.5429 14.6748 17.4004 15.9886 17.2441H15.9873ZM18.0036 14.1566H15.9123V9.05643C15.9123 7.98265 15.4573 7.43763 14.5485 7.43763C13.5435 7.43763 13.0397 8.0839 13.0397 9.36393V12.1553H10.9597V9.36268C10.9597 8.08265 10.4559 7.43639 9.45089 7.43639C8.54212 7.43639 8.08711 7.9814 8.08711 9.05643V14.1553H5.9958V8.90267C5.9958 7.8289 6.27081 6.97637 6.82082 6.34511C7.39084 5.71384 8.13586 5.39008 9.06213 5.39008C10.1322 5.39008 10.9422 5.80009 11.4784 6.61887L11.9997 7.48764L12.521 6.61887C13.0572 5.80009 13.8672 5.39008 14.9385 5.39008C15.8635 5.39008 16.6086 5.71384 17.1773 6.34511C17.7298 6.97637 18.0036 7.8289 18.0036 8.90267V14.1566Z"/>
                        </svg>
                    </a>
                </li>

                <li>
                    <a href="https://www.linkedin.com/in/michaelaspage/" class="text-neutral-500 hover:text-neutral-400">
                        <svg role="img" role="LinkedIn" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.335 18.339H15.67V14.162C15.67 13.166 15.65 11.884 14.28 11.884C12.891 11.884 12.679 12.968 12.679 14.089V18.339H10.013V9.75H12.573V10.92H12.608C12.966 10.246 13.836 9.533 15.136 9.533C17.836 9.533 18.336 11.311 18.336 13.624V18.339H18.335ZM7.003 8.575C6.79956 8.57526 6.59806 8.53537 6.41006 8.45761C6.22207 8.37984 6.05127 8.26574 5.90746 8.12184C5.76365 7.97793 5.64965 7.80706 5.57201 7.61901C5.49437 7.43097 5.4546 7.22944 5.455 7.026C5.4552 6.71983 5.54618 6.4206 5.71644 6.16615C5.8867 5.91169 6.12859 5.71343 6.41153 5.59645C6.69447 5.47947 7.00574 5.44902 7.30598 5.50894C7.60622 5.56886 7.88196 5.71648 8.09831 5.93311C8.31466 6.14974 8.46191 6.42566 8.52145 6.72598C8.58099 7.0263 8.55013 7.33753 8.43278 7.62032C8.31543 7.9031 8.11687 8.14474 7.86219 8.31467C7.60751 8.4846 7.30817 8.5752 7.002 8.575H7.003ZM8.339 18.339H5.666V9.75H8.34V18.339H8.339ZM19.67 3H4.329C3.593 3 3 3.58 3 4.297V19.703C3 20.42 3.594 21 4.328 21H19.666C20.4 21 21 20.42 21 19.703V4.297C21 3.58 20.4 3 19.666 3H19.669H19.67Z"/>
                        </svg>
                    </a>
                </li>

            </ul>
        </div>
        <div class="text-sm text-neutral-500">
            <p>This site has been developed by Mike Page, and is <a href="https://github.com/MikePageDev/mikepage.dev" class="underline hover:text-neutral-400">open source</a></p>
        </div>
    </footer>
</body>
</html>
