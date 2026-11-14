@php
    $sections = [
        [
            'title' => 'About',
            'summary' => 'Who I am, how I work and what I’m available for.',
            'route' => 'about',
            'link' => 'About me',
        ],
        [
            'title' => 'Services',
            'summary' => 'Bespoke business applications, APIs and integrations, and modernising existing PHP systems.',
            'route' => 'services',
            'link' => 'See my services',
        ],
        [
            'title' => 'Portfolio',
            'summary' => 'Case studies of projects I’ve built, with the problem each one solved.',
            'route' => 'portfolio.index',
            'link' => 'Browse case studies',
        ],
    ];
@endphp
<x-layout>
    <div class="py-12 w-full">
        <section class="max-w-2xl mb-16">
            <p class="text-xl sm:text-2xl font-semibold mb-2">Hi, I’m Mike Page</p>
            <h1 class="text-4xl sm:text-5xl font-bold mb-6">PHP and Laravel developer</h1>
            <p class="text-lg sm:text-xl mb-8">
                I build bespoke business software, APIs and Filament admin panels, and I’m available for freelance work alongside a full-time role.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('portfolio.index') }}" class="px-5 py-3 rounded-md font-semibold bg-primary-600 text-white hover:bg-primary-700 dark:hover:bg-primary-500 transition">See my work</a>
                <a href="{{ route('contact') }}" class="px-5 py-3 rounded-md font-semibold border-2 border-primary-600 hover:bg-primary-50 dark:border-primary-400 dark:hover:bg-primary-950 transition">Get in touch</a>
            </div>
        </section>

        <ul class="grid gap-6 sm:grid-cols-3">
            @foreach ($sections as $section)
                <li class="flex flex-col p-5 rounded-md border border-neutral-200 dark:border-neutral-700">
                    <h2 class="text-xl font-bold mb-2">{{ $section['title'] }}</h2>
                    <p class="mb-4 flex-1">{{ $section['summary'] }}</p>
                    <a href="{{ route($section['route']) }}" class="underline font-semibold hover:text-neutral-600 dark:hover:text-neutral-400">{{ $section['link'] }} <span aria-hidden="true">→</span></a>
                </li>
            @endforeach
        </ul>
    </div>
</x-layout>
