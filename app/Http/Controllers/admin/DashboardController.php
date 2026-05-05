<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\User;
use App\Models\Budget;

class DashboardController extends Controller
{

    private function monthFormat(): string
    {
        return config('database.default') === 'mysql'
            ? "DATE_FORMAT(expense_date, '%Y-%m')"
            : "strftime('%Y-%m', expense_date)";
    }
    public function index()
    {
        $stats = [
            'total_users'    => User::count(),
            'total_expenses' => Expense::count(),
            'total_amount'   => Expense::sum('amount'),
            'total_budgets'  => Budget::count(),
            'new_users'      => User::whereMonth('created_at', now()->month)->count(),
            'this_month'     => Expense::whereMonth('expense_date', now()->month)
                ->whereYear('expense_date', now()->year)
                ->sum('amount'),
        ];

        // Top spenders
        $topSpenders = User::withSum('expenses', 'amount')
            ->orderByDesc('expenses_sum_amount')
            ->take(5)
            ->get();

        // Expenses by category
        $byCategory = Expense::selectRaw('category, SUM(amount) as total, COUNT(*) as count')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        // Monthly trend
        $monthlyTrend = Expense::selectRaw("{$this->monthFormat()} as month, SUM(amount) as total")
            ->groupByRaw($this->monthFormat())
            ->orderBy('month')
            ->take(12)
            ->get();

        // Recent expenses
        $recentExpenses = Expense::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard.index', compact(
            'stats',
            'topSpenders',
            'byCategory',
            'monthlyTrend',
            'recentExpenses'
        ));
    }
}
