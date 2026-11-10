<?php

namespace Tests\Feature;

use App\Livewire\ContactForm;
use App\Mail\EnquiryReceived;
use App\Models\Enquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use RuntimeException;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'site.contact_email' => 'owner@example.test',
            'mail.from.address' => 'webenquiry@example.test',
            'mail.from.name' => 'Test Site',
        ]);
    }

    /**
     * @param  array<string, string>  $overrides
     * @return Testable<ContactForm>
     */
    private function fill(array $overrides = []): Testable
    {
        $fields = array_merge([
            'name' => 'Ada Lovelace',
            'email' => 'ada@example.test',
            'message' => 'I would like to discuss a new project.',
        ], $overrides);

        $component = Livewire::test(ContactForm::class);

        foreach ($fields as $field => $value) {
            $component->set("data.$field", $value);
        }

        return $component;
    }

    public function test_renders_the_three_fields_and_submit_button(): void
    {
        Livewire::test(ContactForm::class)
            ->assertSee('Name')
            ->assertSee('Email')
            ->assertSee('Message')
            ->assertSee('Send message');
    }

    public function test_valid_submission_saves_and_emails_the_enquiry(): void
    {
        Mail::fake();

        $component = $this->fill()->call('submit');

        $component->assertHasNoErrors();
        $component
            ->assertSet('sent', true)
            ->assertSee("Thanks, your message has been sent. I'll get back to you as soon as I can.", false)
            ->assertDontSee('Send message');

        $enquiry = Enquiry::sole();
        $this->assertSame('Ada Lovelace', $enquiry->name);
        $this->assertSame('ada@example.test', $enquiry->email);
        $this->assertSame('127.0.0.1', $enquiry->ip_address);
        $this->assertNotNull($enquiry->sent_at);

        Mail::assertSent(EnquiryReceived::class, function (EnquiryReceived $mail) use ($enquiry): bool {
            return $mail->enquiry->is($enquiry)
                && $mail->hasTo('owner@example.test')
                && $mail->hasFrom('webenquiry@example.test')
                && $mail->hasReplyTo('ada@example.test', 'Ada Lovelace');
        });
    }

    /**
     * @return array<string, array{array<string, string>, string, string}>
     */
    public static function invalidInput(): array
    {
        return [
            'missing name' => [['name' => ''], 'data.name', 'required'],
            'name too long' => [['name' => str_repeat('a', 101)], 'data.name', 'max'],
            'missing email' => [['email' => ''], 'data.email', 'required'],
            'invalid email' => [['email' => 'not-an-email'], 'data.email', 'email'],
            'email too long' => [['email' => str_repeat('a', 250).'@example.test'], 'data.email', 'max'],
            'missing message' => [['message' => ''], 'data.message', 'required'],
            'message too short' => [['message' => 'Hi there'], 'data.message', 'min'],
            'message too long' => [['message' => str_repeat('a', 5001)], 'data.message', 'max'],
            'line break in name' => [['name' => "Ada\r\nBcc: victim@example.test"], 'data.name', 'not_regex'],
            'control character in name' => [['name' => "Ada\x07Lovelace"], 'data.name', 'not_regex'],
            'email the mailer would reject' => [['email' => 'ada(comment)@example.test'], 'data.email', 'email'],
            'quoted local part' => [['email' => '"<script>alert(1)</script>"@example.test'], 'data.email', 'email'],
        ];
    }

    /**
     * @param  array<string, string>  $overrides
     */
    #[DataProvider('invalidInput')]
    public function test_invalid_input_is_rejected(array $overrides, string $field, string $rule): void
    {
        Mail::fake();

        $component = $this->fill($overrides)->call('submit');

        $component->assertHasErrors([$field => $rule]);
        $component->assertSet('sent', false);

        $this->assertSame(0, Enquiry::count());
        Mail::assertNothingSent();
    }

    /**
     * @return array<string, array{string}>
     */
    public static function fields(): array
    {
        return [
            'name' => ['name'],
            'email' => ['email'],
            'message' => ['message'],
        ];
    }

    #[DataProvider('fields')]
    public function test_array_values_are_rejected_not_a_server_error(string $field): void
    {
        Mail::fake();

        $component = $this->fill()
            ->set("data.$field", array_fill(0, 12, 'a'))
            ->call('submit');

        $component->assertHasErrors(["data.$field" => 'string']);
        $this->assertSame(0, Enquiry::count());
        Mail::assertNothingSent();
    }

    public function test_file_uploads_are_refused(): void
    {
        Livewire::test(ContactForm::class)
            ->call('_startUpload', 'data.name', [['name' => 'big.bin', 'size' => 12_000_000, 'type' => 'application/octet-stream']], false)
            ->assertForbidden();
    }

    public function test_ordinary_international_addresses_are_still_accepted(): void
    {
        Mail::fake();

        $component = $this->fill(['email' => 'jörg@example.test'])->call('submit');

        $component->assertHasNoErrors();
        $this->assertSame(1, Enquiry::count());
    }

    public function test_whitespace_only_fields_are_rejected(): void
    {
        Mail::fake();

        $this->fill(['name' => '     ', 'message' => '               '])
            ->call('submit')
            ->assertHasErrors(['data.name' => 'required', 'data.message' => 'required']);

        $this->assertSame(0, Enquiry::count());
        Mail::assertNothingSent();
    }

    public function test_filled_honeypot_pretends_success_but_saves_and_sends_nothing(): void
    {
        Mail::fake();

        $this->fill()
            ->set('website', 'https://spam.example')
            ->call('submit')
            ->assertSet('sent', true)
            ->assertSee('Thanks, your message has been sent.');

        $this->assertSame(0, Enquiry::count());
        Mail::assertNothingSent();
    }

    public function test_fourth_attempt_within_a_minute_is_rate_limited(): void
    {
        Mail::fake();

        $component = $this->fill(['email' => 'not-an-email']);

        foreach (range(1, 3) as $attempt) {
            $component->call('submit')->assertHasErrors(['data.email' => 'email']);
        }

        $component
            ->set('data.email', 'ada@example.test')
            ->call('submit')
            ->assertSee('Too many attempts. Please try again in')
            ->assertSet('sent', false);

        $this->assertSame(0, Enquiry::count());
    }

    public function test_form_works_again_after_the_rate_limit_window(): void
    {
        Mail::fake();

        $component = $this->fill(['email' => 'not-an-email']);

        foreach (range(1, 4) as $attempt) {
            $component->call('submit');
        }

        $this->travel(61)->seconds();

        $component
            ->set('data.email', 'ada@example.test')
            ->call('submit')
            ->assertSet('sent', true)
            ->assertDontSee('Too many attempts');

        $this->assertSame(1, Enquiry::count());
    }

    public function test_mail_failure_keeps_the_enquiry_and_still_shows_success(): void
    {
        Exceptions::fake();
        Mail::shouldReceive('send')->once()->andThrow(new RuntimeException('SMTP is down'));

        $this->fill()
            ->call('submit')
            ->assertSet('sent', true);

        $this->assertNull(Enquiry::sole()->sent_at);
        Exceptions::assertReported(RuntimeException::class);
    }

    public function test_missing_contact_email_saves_without_sending_and_logs_a_warning(): void
    {
        Mail::fake();
        Log::shouldReceive('warning')->once();
        config(['site.contact_email' => null]);

        $this->fill()
            ->call('submit')
            ->assertSet('sent', true);

        $this->assertNull(Enquiry::sole()->sent_at);
        Mail::assertNothingSent();
    }
}
