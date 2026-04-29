<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $userId = $request->user()->id;

        $totalAll = Expense::forUser($userId)->sum('amount');

        $totalThisMonth = Expense::forUser($userId)
            ->whereRaw("strftime('%Y-%m', expense_date) = ?", [now()->format('Y-m')])
            ->sum('amount');

        $totalThisWeek = Expense::forUser($userId)
            ->whereBetween('expense_date', [
                now()->startOfWeek()->format('Y-m-d'),
                now()->endOfWeek()->format('Y-m-d'),
            ])
            ->sum('amount');

        $totalExpenses = Expense::forUser($userId)->count();

        $byCategory = Expense::forUser($userId)
            ->selectRaw('category, SUM(amount) as total, COUNT(*) as count')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $recentExpenses = Expense::forUser($userId)
            ->orderByDesc('expense_date')
            ->limit(5)
            ->get();

        $monthlySpending = Expense::forUser($userId)
            ->selectRaw("
                strftime('%Y', expense_date) as year,
                strftime('%m', expense_date) as month,
                SUM(amount) as total
            ")
            ->where('expense_date', '>=', now()->subMonths(6)->format('Y-m-d'))
            ->groupByRaw("strftime('%Y', expense_date), strftime('%m', expense_date)")
            ->orderByRaw("strftime('%Y', expense_date), strftime('%m', expense_date)")
            ->get()
            ->map(fn($row) => [
                'label' => \Carbon\Carbon::createFromDate($row->year, $row->month, 1)->format('M Y'),
                'total' => $row->total,
            ]);

        return view('dashboard', compact(
            'totalAll',
            'totalThisMonth',
            'totalThisWeek',
            'totalExpenses',
            'byCategory',
            'recentExpenses',
            'monthlySpending',
        ));
    }
}