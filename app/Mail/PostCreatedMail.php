<?php

namespace App\Mail;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PostCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Post $post;
    

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    
    public function envelope()
    {
        return new Envelope(
            subject: 'Post Created Mail \n',
        );
    }

    
    public function content()
    {
        return new Content(
            view: 'mails.post-created',
        );
    }

    
    public function attachments()
    {
        return [];
    }
}
