@php
    // Trim to the work you actually want to attract. 'body' is optional.
    $services = [
        [
            'title' => 'Bespoke Web Applications',
            'summary' => 'Custom applications designed around your specific processes and requirements.',
            'body' => 'Whether you need a new internal system or want to replace a collection of spreadsheets and manual processes, I can design and build a solution that fits the way your business actually works.',
        ],
        [
            'title' => 'Laravel & Filament Development',
            'summary' => 'Development of modern PHP applications using Laravel and Filament.',
            'body' => 'From administration panels and internal tools to complete business applications, I use these frameworks to build software that is reliable, maintainable and straightforward to extend.',
        ],
        [
            'title' => 'APIs & Integrations',
            'summary' => 'Connecting applications and services so that your systems can work together.',
            'body' => 'I can build APIs and integrations between your existing software, third-party services and bespoke applications, reducing manual data entry and helping information flow where it needs to.',
        ],
        [
            'title' => 'Legacy Application Modernisation',
            'summary' => 'Existing software does not always need to be replaced.',
            'body' => 'I can help assess, maintain and modernise older PHP applications, gradually improving their reliability and maintainability while keeping the business running.',
        ],
        [
            'title' => 'Software Maintenance & Troubleshooting',
            'summary' => 'Ongoing development and maintenance for existing applications.',
            'body' => 'Whether you need help fixing problems, adding functionality or keeping an application moving forward, I can work with your existing codebase and become an additional development resource for your team. That includes tracking down bugs, performance problems and security issues, and upgrading outdated dependencies.',
        ],
        [
            'title' => 'Database-Driven Applications',
            'summary' => 'Data modelling, migrations, reporting and query performance for MySQL-backed applications.',
            'body' => 'Business software is only as good as the data behind it. I can design database structures that reflect how your business works, change them safely as requirements evolve, build the reports you need and keep queries fast as your data grows.',
        ],
    ];
@endphp
<x-layout title="Services" description="Laravel, Filament, API and backend development services for new and existing web applications.">
    <section class="py-12 w-full">
        <h1 class="text-4xl sm:text-5xl font-bold mb-4">Services</h1>
        <p class="text-lg mb-4">
            I help businesses build, improve and maintain the software they rely on.
        </p>
        <p class="text-lg mb-10">
            My work focuses on practical, bespoke applications built around the needs of the business rather than forcing a business into an off-the-shelf solution.
        </p>

        <ul class="grid gap-6 sm:grid-cols-2 mb-10">
            @foreach ($services as $service)
                <li class="p-5 rounded-md border border-neutral-200 dark:border-neutral-700">
                    <h2 class="text-xl font-bold mb-2">{{ $service['title'] }}</h2>
                    <p class="font-semibold mb-2">{{ $service['summary'] }}</p>
                    @isset($service['body'])
                        <p>{{ $service['body'] }}</p>
                    @endisset
                </li>
            @endforeach
        </ul>

        <h2 class="text-2xl font-bold mb-3">Let's Talk</h2>
        <p class="text-lg mb-4">
            If you have a new project, an existing application that needs attention, or a process that could be improved with better software, <a href="{{ route('contact') }}" class="underline font-semibold hover:text-neutral-600 dark:hover:text-neutral-400">get in touch</a>.
        </p>
        <p class="text-lg">
            We can discuss what you need and work out the best way forward.
        </p>
    </section>
</x-layout>
