<?php

namespace Tests\Feature;

use App\Mail\EnquiryReceived;
use App\Models\Enquiry;
use Tests\TestCase;

class EnquiryReceivedTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'site.contact_email' => 'owner@example.test',
            'mail.from.address' => 'webenquiry@example.test',
            'mail.from.name' => 'Test Site',
        ]);
    }

    private function mailable(string $message = 'Hello, I need some help.'): EnquiryReceived
    {
        return new EnquiryReceived(Enquiry::factory()->make([
            'name' => 'Ada Lovelace',
            'email' => 'ada@example.test',
            'message' => $message,
        ]));
    }

    public function test_addresses_and_subject(): void
    {
        $this->mailable()
            ->assertTo('owner@example.test')
            ->assertFrom('webenquiry@example.test', 'Test Site')
            ->assertHasReplyTo('ada@example.test', 'Ada Lovelace')
            ->assertHasSubject('Website enquiry from Ada Lovelace');
    }

    public function test_bodies_show_the_enquiry(): void
    {
        $this->mailable()
            ->assertSeeInHtml('Ada Lovelace')
            ->assertSeeInHtml('ada@example.test')
            ->assertSeeInHtml('Hello, I need some help.')
            ->assertSeeInText('Ada Lovelace')
            ->assertSeeInText('ada@example.test')
            ->assertSeeInText('Hello, I need some help.');
    }

    public function test_visitor_html_is_escaped_in_the_html_body(): void
    {
        $this->mailable('<script>alert(1)</script> **bold**')
            ->assertSeeInHtml('&lt;script&gt;alert(1)&lt;/script&gt; **bold**', false)
            ->assertDontSeeInHtml('<script>alert(1)</script>', false);
    }

    public function test_text_body_shows_message_verbatim(): void
    {
        $this->mailable('Tom & Jerry <hi> **bold**')
            ->assertSeeInText('Tom & Jerry <hi> **bold**');
    }

    public function test_message_line_breaks_are_preserved_in_html(): void
    {
        $this->mailable("Line one\nLine two")
            ->assertSeeInHtml('Line one<br />', false);
    }
}
