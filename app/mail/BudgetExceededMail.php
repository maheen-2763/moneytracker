<?php

namespace App\Mail;

use App\Models\Budget;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BudgetExceededMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User   $user,
        public Budget $budget,
        public float  $spent,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🚨 Budget Alert — ' . ucfirst($this->budget->category) . ' limit exceeded!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.budget-exceeded',
            with: [
                'user'   => $this->user,
                'budget' => $this->budget,
                'spent'  => $this->spent,
            ],
        );
    }
}
