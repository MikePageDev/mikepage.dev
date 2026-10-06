<?php

namespace App\Mail;

use App\Models\Enquiry;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class EnquiryReceived extends Mailable
{
    public function __construct(public Enquiry $enquiry) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config()->string('mail.from.address'), config()->string('mail.from.name')),
            to: [new Address(config()->string('site.contact_email'))],
            replyTo: [new Address($this->enquiry->email, $this->enquiry->name)],
            subject: 'Website enquiry from '.$this->enquiry->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.enquiry-received',
            text: 'mail.enquiry-received-text',
        );
    }
}
