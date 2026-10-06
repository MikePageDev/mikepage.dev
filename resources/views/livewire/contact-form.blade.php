<div id="form" class="mb-8">
    @if ($sent)
        <p role="status" class="text-lg font-semibold p-5 rounded-md border border-neutral-200 dark:border-neutral-700">
            Thanks, your message has been sent. I'll get back to you as soon as I can.
        </p>
    @else
        <form wire:submit="submit" class="flex flex-col gap-6">
            {{ $this->form }}

            <div aria-hidden="true" class="absolute -left-[9999px] w-px h-px overflow-hidden">
                <label for="website">Leave this field empty</label>
                <input type="text" id="website" wire:model="website" tabindex="-1" autocomplete="off">
            </div>

            @if ($retryAfter)
                <p role="alert" class="text-red-600 dark:text-red-400">
                    Too many attempts. Please try again in {{ $retryAfter }} seconds.
                </p>
            @endif

            <div>
                <x-filament::button type="submit" size="lg">
                    Send message
                </x-filament::button>
            </div>
        </form>
    @endif
</div>
