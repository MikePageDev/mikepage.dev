@php
    $status = $exception->getStatusCode();

    [$heading, $message] = match ($status) {
        401 => ['Please log in', 'You need to log in to see this page.'],
        402 => ['Payment required', 'This page isn’t available without payment.'],
        403 => ['Access denied', 'You don’t have permission to see this page.'],
        404 => ['Page not found', 'The page you’re looking for doesn’t exist or has moved.'],
        419 => ['Page expired', 'Your session ran out. Go back, refresh the page and try again.'],
        429 => ['Too many requests', 'Please wait a moment and try again.'],
        default => ['Something went wrong', 'That request couldn’t be completed.'],
    };
@endphp
<x-layout :title="$heading">
    <section class="flex flex-1 justify-center items-center py-12">
        <div class="max-w-2xl mx-auto text-center">
            <p class="text-lg text-neutral-500 mb-2">Error {{ $status }}</p>
            <h1 class="text-4xl sm:text-5xl font-bold mb-6">{{ $heading }}</h1>
            <p class="text-lg sm:text-xl mb-8">{{ $message }}</p>
            <p class="text-lg">
                <a href="{{ route('home') }}" class="underline font-semibold hover:text-neutral-600 dark:hover:text-neutral-400">Go to the home page</a>
                or <a href="{{ route('contact') }}" class="underline font-semibold hover:text-neutral-600 dark:hover:text-neutral-400">get in touch</a>.
            </p>
        </div>
    </section>
</x-layout>
