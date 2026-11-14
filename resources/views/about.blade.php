@php
    $availableFor = ['Fixed-price projects', 'Short-term development assignments', 'Ongoing development and maintenance', 'Legacy PHP/Laravel work', 'Modernisation and upgrade projects'];
@endphp
<x-layout title="About" description="Background, skills and approach of a PHP and Laravel developer available for freelance work.">
    <article class="max-w-2xl mx-auto py-12 w-full">
        <h1 class="text-4xl sm:text-5xl font-bold mb-8">About me</h1>

        <section class="mb-10">
            <p class="mb-2">
                I’m Mike Page, a PHP and Laravel developer with a focus on building practical software that solves real business problems.
            </p>
            <p class="mb-2">
                My work is centred around PHP and the modern PHP ecosystem, including Laravel and Filament. I enjoy taking complex requirements and turning them into straightforward, maintainable applications that people can actually use.
            </p>
        </section>

        <section class="mb-10">
            <h2 class="text-2xl font-bold mb-3">What I do</h2>
            <p class="mb-2">
                I specialise in building bespoke internal applications and business software for organisations whose processes don’t fit neatly into off-the-shelf systems. That can mean replacing spreadsheet-heavy processes, bringing disconnected systems together, building internal administration tools, or developing applications around the way a business actually works.
            </p>
            <p class="mb-2">
                I also build APIs and integrations, and improve and modernise existing systems. I’m particularly interested in the parts of development that sit between the technical and business sides of a project — understanding what a business needs and then building the right solution.
            </p>
            <p class="mb-2">
                I work across the full development lifecycle — from understanding requirements and designing the solution, through development and testing, to deployment and ongoing support.
            </p>
        </section>

        <section class="mb-10">
            <h2 class="text-2xl font-bold mb-3">Working with me</h2>
            <p class="mb-4">
                I’m a full-time employed developer, with availability for freelance development work alongside my main role. I’m available for:
            </p>
            <ul class="list-disc pl-6 mb-4 space-y-1">
                @foreach ($availableFor as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
            <p class="mb-2">
                See my <a href="{{ route('services') }}" class="underline font-semibold hover:text-neutral-600 dark:hover:text-neutral-400">services</a> for more on the kind of work I take on.
            </p>
        </section>

        <section class="mb-10">
            <h2 class="text-2xl font-bold mb-3">PHP community</h2>
            <p class="mb-2">
                I’m passionate about PHP as a community and as a platform. I co-host the
                <a href="https://www.youtube.com/playlist?list=PLJPRYJOPv4pTROVkhb1IfRP-RvpJcPaJ9" target="_blank" rel="noopener noreferrer" class="underline font-semibold hover:text-neutral-600 dark:hover:text-neutral-400">PHP Alive and Kicking</a>
                podcast, where we talk about the people, projects and ideas that continue to make PHP relevant.
            </p>
            <p class="mb-2">
                I believe PHP has a strong future. Rather than spending time defending why PHP is still around, I prefer to focus on what developers are actually building with it — and on helping show the next generation of developers what is possible.
            </p>
        </section>

        <p>
            If your business is relying on manual processes, spreadsheets or systems that don’t work well together, or you have a project that needs additional PHP/Laravel expertise, <a href="{{ route('contact') }}" class="underline font-semibold hover:text-neutral-600 dark:hover:text-neutral-400">get in touch</a>.
        </p>
    </article>
</x-layout>
