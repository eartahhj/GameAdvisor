<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DataRequestToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    protected string $userEmail = '';

    /**
     * Create a new message instance.
     */
    public function __construct(string $emailBody, string $userEmail = '')
    {
        $this->emailBody = $emailBody;
        $this->userEmail = $userEmail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: env('APP_EMAIL_PUBLIC'),
            subject: _('New data request'),
            replyTo: $this->userEmail
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            text: 'emails.dataRequestToAdmin',
            with: ['emailBody' => $this->emailBody]
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
