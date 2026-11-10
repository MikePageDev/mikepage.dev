<x-layout title="Contact" description="Get in touch about Laravel development work.">
    <section class="flex flex-1 justify-center items-center py-12">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-4xl sm:text-5xl font-bold mb-6">Get in Touch</h1>
            <p class="text-lg sm:text-xl mb-4">
                Have a project in mind, need help with an existing application, or simply want to discuss an idea?
            </p>
            <p class="text-lg sm:text-xl mb-10">
                I’m always happy to have an initial conversation and see if I can help.
            </p>

            <h2 class="text-2xl font-bold mb-3">Start a Conversation</h2>
            <p class="text-lg mb-4">
                If you have a project or development requirement, send me a message with a little information about what you’re looking to achieve.
            </p>
            <p class="text-lg mb-6">
                There’s no need to have everything figured out before getting in touch. A brief description of the problem or idea is enough to start the conversation.
            </p>

            <livewire:contact-form />

            @if ($email = config('site.contact_email'))
                <p class="text-lg mb-4">
                    Prefer email?
                    <a href="mailto:{{ $email }}" class="underline font-semibold break-all hover:text-neutral-600 dark:hover:text-neutral-400">{{ $email }}</a>
                </p>
            @endif
            <p class="text-lg">
                I’ll get back to you as soon as I can.
            </p>
        </div>
    </section>
</x-layout>
