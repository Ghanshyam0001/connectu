<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetLinKmail extends Mailable
{
    use Queueable, SerializesModels;

    public $authormail;
    public $authorname;
    public $authortoken;


    /**
     * Create a new message instance.
     */
    public function __construct( $toEamil,$name, $tokens)
    {
        $this->authormail = $toEamil;
        $this->authorname = $name;
        $this->authortoken = $tokens;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Password Link',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'adminpaneal.authauthor.resetlinkmail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
