<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // GET /api/dashboard
    public function index(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        $totalAllTime = Expense::where('user_id', $userId)->sum('amount');

        $thisMonth = Expense::where('user_id', $userId)
            ->whereMonth('expense_date', now()->month)
            ->whereYear('expense_date',  now()->year)
            ->sum('amount');

        $thisWeek = Expense::where('user_id', $userId)
            ->whereBetween('expense_date', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ])
            ->sum('amount');

        $totalExpenses = Expense::where('user_id', $userId)->count();

        $byCategory = Expense::where('user_id', $userId)
            ->selectRaw('category, SUM(amount) as total, COUNT(*) as count')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $byMonth = Expense::where('user_id', $userId)
            ->selectRaw("DATE_FORMAT(expense_date, '%Y-%m') as month, SUM(amount) as total")
            ->groupByRaw("DATE_FORMAT(expense_date, '%Y-%m')")
            ->orderBy('month')
            ->get();

        return response()->json([
            'summary' => [
                'total_all_time'  => round($totalAllTime, 2),
                'this_month'      => round($thisMonth, 2),
                'this_week'       => round($thisWeek, 2),
                'total_expenses'  => $totalExpenses,
            ],
            'by_category' => $byCategory,
            'by_month'    => $byMonth,
        ]);
    }
}
