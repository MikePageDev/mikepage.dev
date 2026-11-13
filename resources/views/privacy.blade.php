@php
    $link = 'underline font-semibold hover:text-neutral-600 dark:hover:text-neutral-400';
@endphp
<x-layout title="Privacy notice" description="How this site handles the personal data you send through the contact form.">
    <article class="max-w-2xl mx-auto py-12 w-full">
        <h1 class="text-4xl sm:text-5xl font-bold mb-4">Privacy notice</h1>
        <p class="mb-10 text-neutral-500">Last updated 11 November 2026</p>

        <section class="mb-10">
            <h2 class="text-2xl font-bold mb-3">Who I am</h2>
            <p class="mb-2">
                This site is run by Mike Page, a sole trader based in the UK. I am responsible for any personal data you send through it.
                If you have any questions about your data, email me at
                <a href="mailto:mike@mikepage.dev" class="{{ $link }}">mike@mikepage.dev</a>.
            </p>
        </section>

        <section class="mb-10">
            <h2 class="text-2xl font-bold mb-3">What I collect</h2>
            <p class="mb-2">
                The only personal data this site collects is what you send through the contact form: your name, email address and message.
                The IP address you send it from is also recorded.
            </p>
            <p class="mb-2">
                There is no analytics or tracking. The site only sets the cookies it needs to work: one that keeps your session and one that protects the contact form against forged submissions.
                If you switch to dark mode, that choice is saved in your own browser and never sent to me.
            </p>
        </section>

        <section class="mb-10">
            <h2 class="text-2xl font-bold mb-3">Why I use it</h2>
            <p class="mb-2">
                I use your name, email address and message to reply to your enquiry and to discuss any work you might want done. The legal basis is taking steps, at your request, before we might enter into a contract.
            </p>
            <p class="mb-2">
                I keep the IP address to spot and stop spam and abuse of the contact form. The legal basis is my legitimate interest in keeping the form usable.
            </p>
            <p class="mb-2">
                I never sell your data or use it for marketing.
            </p>
        </section>

        <section class="mb-10">
            <h2 class="text-2xl font-bold mb-3">Who else handles it</h2>
            <p class="mb-2">Two companies handle your data on my behalf:</p>
            <ul class="list-disc pl-6 mb-2 space-y-1">
                <li>DigitalOcean hosts this site and stores enquiries on its servers in London.</li>
                <li>Zoho delivers each enquiry to my inbox and stores that email in its EU data centre.</li>
            </ul>
            <p class="mb-2">Nobody else sees it.</p>
        </section>

        <section class="mb-10">
            <h2 class="text-2xl font-bold mb-3">How long I keep it</h2>
            <p class="mb-2">
                Enquiries are deleted automatically after 12 months, and IP addresses after 30 days.
                I delete the emailed copy of your enquiry from my inbox on the same schedule.
            </p>
            <p class="mb-2">
                If you become a client, the details needed to work with you move into my business records, which I keep for as long as the law requires.
            </p>
        </section>

        <section class="mb-10">
            <h2 class="text-2xl font-bold mb-3">Your rights</h2>
            <p class="mb-2">
                You can ask to see the data I hold about you, ask me to correct or delete it, or object to how I use it.
                Email <a href="mailto:mike@mikepage.dev" class="{{ $link }}">mike@mikepage.dev</a> and I will reply within one month.
            </p>
            <p class="mb-2">
                If you are unhappy with how I have handled your data, you can complain to the
                <a href="https://ico.org.uk/make-a-complaint/" target="_blank" rel="noopener noreferrer" class="{{ $link }}">Information Commissioner’s Office</a>.
            </p>
        </section>
    </article>
</x-layout>
