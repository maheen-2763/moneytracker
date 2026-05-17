<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WeeklyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User  $user,
        public array $data,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Weekly MoneyTracker Report — '
                . now()->startOfWeek()->format('d M')
                . ' to '
                . now()->endOfWeek()->format('d M Y'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.weekly-report',
            with: [
                'user'   => $this->user,
                'data'   => $this->data,
            ],
        );
    }
}
