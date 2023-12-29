<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>
        @vite('resources/css/app.css')
    </head>
    <body>
        <h1 class="text-3xl font-bold underline">Hello World!</h1>
    </body>
</html>
