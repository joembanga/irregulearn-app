<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerbsExportMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public User $user,
        public string $pdfContent
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ta liste de verbes est prête ! 📖',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.verbs-export',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->pdfContent, 'MaListeVerbes.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
