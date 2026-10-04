<x-layout>
    <section class="flex flex-1 justify-center items-center py-12">
        <div class="max-w-lg mx-auto">
            <h1 class="text-4xl sm:text-5xl font-bold mb-6">Freelance Laravel developer</h1>
            <p class="text-lg sm:text-xl mb-4">
                Hi, my name is Mike. I build and maintain web applications with PHP and Laravel, from new projects to long-running systems that need extending, fixing or modernising.
            </p>
            <p class="text-lg sm:text-xl mb-8">
                I work with businesses and teams who need a dependable backend developer: someone who can pick up an existing codebase, understand it quickly and ship changes safely.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('portfolio') }}" class="px-5 py-3 rounded-md font-semibold bg-neutral-900 text-white hover:bg-neutral-700 dark:bg-white dark:text-neutral-900 dark:hover:bg-neutral-200 transition">See my work</a>
                <a href="{{ route('contact') }}" class="px-5 py-3 rounded-md font-semibold border-2 border-neutral-900 hover:bg-neutral-100 dark:border-white dark:hover:bg-neutral-800 transition">Get in touch</a>
            </div>
        </div>
    </section>
</x-layout>
