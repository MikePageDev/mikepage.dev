<?php

namespace App\Livewire;

use App\Mail\EnquiryReceived;
use App\Models\Enquiry;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Concerns\RestrictsFileUploadsToSchemaComponents;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Throwable;

/**
 * @property-read Schema $form
 */
class ContactForm extends Component implements HasSchemas
{
    use InteractsWithSchemas;

    // The form has no upload fields, so this closes Livewire's upload endpoint for it.
    use RestrictsFileUploadsToSchemaComponents;
    use WithRateLimiting;

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    // Honeypot: real visitors never see or fill this field.
    public string $website = '';

    public bool $sent = false;

    public ?int $retryAfter = null;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->rule('string')
                    // No line breaks or other control characters: the name goes into the subject and Reply-To.
                    ->rule('not_regex:/[\x00-\x1F\x7F]/')
                    ->maxLength(100),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->rule('string')
                    // Strict matches what the mailer accepts, so a valid-looking address is never saved but unsendable.
                    ->rule('email:strict')
                    ->maxLength(255),
                Textarea::make('message')
                    ->label('Message')
                    ->required()
                    ->rule('string')
                    ->minLength(10)
                    ->maxLength(5000)
                    ->rows(6),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        try {
            $this->rateLimit(3);
        } catch (TooManyRequestsException $exception) {
            $seconds = $exception->secondsUntilAvailable;
            $this->retryAfter = is_int($seconds) ? $seconds : 60;

            return;
        }

        $this->retryAfter = null;

        if ($this->website !== '') {
            // Looks like a bot: pretend it worked, keep nothing.
            $this->sent = true;

            return;
        }

        $state = $this->form->getState();

        $enquiry = Enquiry::create([
            'name' => $state['name'],
            'email' => $state['email'],
            'message' => $state['message'],
            'ip_address' => request()->ip(),
        ]);

        $this->send($enquiry);

        $this->sent = true;
    }

    private function send(Enquiry $enquiry): void
    {
        $to = config('site.contact_email');

        if (! is_string($to) || $to === '') {
            Log::warning('CONTACT_EMAIL is not set; enquiry saved but not emailed.', ['enquiry_id' => $enquiry->id]);

            return;
        }

        try {
            Mail::send(new EnquiryReceived($enquiry));
            $enquiry->update(['sent_at' => now()]);
        } catch (Throwable $exception) {
            // The enquiry is stored, so the visitor still sees success; find failures with whereNull('sent_at').
            report($exception);
        }
    }

    public function render(): View
    {
        return view('livewire.contact-form');
    }
}
