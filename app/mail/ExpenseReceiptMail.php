<?php

namespace App\Mail;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExpenseReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User    $user,
        public Expense $expense,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🧾 Expense Added — ₹' . number_format($this->expense->amount, 2),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.expense-receipt',
        );
    }
}
