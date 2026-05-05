<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // ── Summary stats ──────────────────────
        $totalAllTime = Expense::where('user_id', $userId)
            ->sum('amount');

        $thisMonth = Expense::where('user_id', $userId)
            ->whereMonth('expense_date', now()->month)
            ->whereYear('expense_date',  now()->year)
            ->sum('amount');

        $thisWeek = Expense::where('user_id', $userId)
            ->whereBetween('expense_date', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ])->sum('amount');

        $totalExpenses = Expense::where('user_id', $userId)->count();

        // ── Monthly trend (last 6 months) ──────
        $isMySQL = config('database.default') === 'mysql';
        $fmt = $isMySQL
            ? "DATE_FORMAT(expense_date, '%Y-%m')"
            : "strftime('%Y-%m', expense_date)";

        $monthlyTrend = Expense::where('user_id', $userId)
            ->where('expense_date', '>=', now()->subMonths(6))
            ->selectRaw("$fmt as month, SUM(amount) as total")
            ->groupByRaw($fmt)
            ->orderBy('month')
            ->get();

        // ── Category breakdown (this month) ────
        $categoryBreakdown = Expense::where('user_id', $userId)
            ->whereMonth('expense_date', now()->month)
            ->whereYear('expense_date',  now()->year)
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        // ── Budgets ────────────────────────────
        $budgets = Budget::where('user_id', $userId)->get();

        // ── Recent expenses ────────────────────
        $recentExpenses = Expense::where('user_id', $userId)
            ->latest('expense_date')
            ->take(6)
            ->get();

        return view('dashboard', compact(
            'totalAllTime',
            'thisMonth',
            'thisWeek',
            'totalExpenses',
            'monthlyTrend',
            'categoryBreakdown',
            'budgets',
            'recentExpenses',
        ));
    }
}
