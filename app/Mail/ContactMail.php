<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function envelope()
    {
        return new Envelope(
            from: $this->message->email,
            subject: $this->message->subject,
        );
    }

    public function content()
    {
        return new Content(
            view: 'mails.contact',
            with: [
                'message' => $this->message
            ]
        );
    }

    public function attachments()
    {
        return [];
    }
}
