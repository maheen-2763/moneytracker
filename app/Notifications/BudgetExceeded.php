<?php

namespace App\Notifications;

use App\Mail\BudgetExceededMail;
use App\Models\Budget;
use Illuminate\Notifications\Notification;

class BudgetExceeded extends Notification
{
    public function __construct(public Budget $budget, public float $spent) {}

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type'     => 'budget_exceeded',
            'category' => $this->budget->category,
            'spent'    => $this->spent,
            'limit'    => $this->budget->amount,
            'message'  => ucfirst($this->budget->category) . ' budget exceeded! '
                . '₹' . number_format($this->spent, 0)
                . ' spent of ₹' . number_format((float) $this->budget->amount, 0) . ' limit.',
        ];
    }

    public function toMail($notifiable): BudgetExceededMail
    {
        return (new BudgetExceededMail(
            $notifiable,
            $this->budget,
            $this->spent
        ))->to($notifiable->email);
    }
}
