<x-layout title="Contact" description="Get in touch about Laravel development work.">
    <section class="flex flex-1 justify-center items-center py-12">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-4xl sm:text-5xl font-bold mb-6">Get in touch</h1>
            <p class="text-lg sm:text-xl mb-8">
                Have a project in mind, need help with an existing application, or want to talk through an idea? Send me a short message. There’s no need to have everything figured out first.
            </p>

            <livewire:contact-form />

            @if ($email = config('site.contact_email'))
                <p class="text-lg mb-4">
                    Prefer email?
                    <a href="mailto:{{ $email }}" class="underline font-semibold break-all hover:text-neutral-600 dark:hover:text-neutral-400">{{ $email }}</a>
                </p>
            @endif
            <p class="text-lg">
                I reply to every enquiry within 3 working days.
            </p>
        </div>
    </section>
</x-layout>
