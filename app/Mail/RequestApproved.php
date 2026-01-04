<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestApproved extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */


    public $approvedemail;
    public $approverequest;

    public $approve;

    public $whishes;
    public $loginlink;

    public function __construct($toEamil, $request, $approved, $bestwhishes, $login)
    {
        $this->approvedemail = $toEamil;
        $this->approverequest = $request;
        $this->approve = $approved;
        $this->whishes = $bestwhishes;
        $this->loginlink = $login;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Author Request Approved',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'adminpaneal.dashboards.approvedauthor',
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
