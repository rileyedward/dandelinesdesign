<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

abstract class BaseMailable extends Mailable
{
    use Queueable, SerializesModels;

    protected string $viewName;

    public $viewData = [];

    public function envelope(): Envelope
    {
        return new Envelope(
            from: config('mail.from.address'),
            subject: $this->getSubject(),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: $this->viewName,
            with: $this->viewData,
        );
    }

    public function attachments(): array
    {
        return [];
    }

    abstract protected function getSubject(): string;
}
