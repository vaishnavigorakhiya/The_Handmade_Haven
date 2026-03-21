<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactInquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Contact $contact) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Contact Inquiry from ' . $this->contact->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            // Fixed: was 'emails.contact-inquiry' but the view file is at
            // resources/views/contact-inquiry.blade.php
            view: 'contact-inquiry',
        );
    }
}
