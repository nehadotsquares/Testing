<?php

namespace App\Mail;

use App\Models\Blog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BlogCreatedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $blog;
    /**
     * Create a new message instance.
     */
    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }

    public function build()
    {
        return $this->subject('A new blog was created!')
                    ->markdown('emails.blog_created');
    }
}
