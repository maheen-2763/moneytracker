<?php

namespace App\Console\Commands;

use App\Mail\WeeklyReportMail;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendWeeklyReports extends Command
{
    protected $signature   = 'reports:weekly';
    protected $description = 'Send weekly expense reports to all users';

    public function handle(): void
    {
        $users = User::all();

        foreach ($users as $user) {

            $thisWeek = Expense::where('user_id', $user->id)
                ->whereBetween('expense_date', [
                    now()->startOfWeek(),
                    now()->endOfWeek(),
                ])->sum('amount');

            // Skip if no expenses this week
            if ($thisWeek == 0) continue;

            $data = [
                'this_week'       => $thisWeek,
                'this_month'      => Expense::where('user_id', $user->id)
                    ->whereMonth('expense_date', now()->month)
                    ->sum('amount'),
                'expense_count'   => Expense::where('user_id', $user->id)
                    ->whereBetween('expense_date', [
                        now()->startOfWeek(),
                        now()->endOfWeek(),
                    ])->count(),
                'daily_avg'       => round($thisWeek / 7, 2),
                'top_category'    => Expense::where('user_id', $user->id)
                    ->whereBetween('expense_date', [
                        now()->startOfWeek(),
                        now()->endOfWeek(),
                    ])
                    ->selectRaw('category, SUM(amount) as total, COUNT(*) as count')
                    ->groupBy('category')
                    ->orderByDesc('total')
                    ->first(),
                'recent_expenses' => Expense::where('user_id', $user->id)
                    ->whereBetween('expense_date', [
                        now()->startOfWeek(),
                        now()->endOfWeek(),
                    ])
                    ->latest('expense_date')
                    ->take(5)
                    ->get(),
                'budgets'         => $user->budgets,
            ];

            Mail::to($user->email)
                ->send(new WeeklyReportMail($user, $data));

            $this->info("✅ Report sent to {$user->email}");
        }

        $this->info('Weekly reports sent successfully!');
    }
}
