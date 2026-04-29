<?php

namespace App\Http\Controllers;

use App\Models\Expense;

class ReportController extends Controller
{
    public function index()
    {
        $filters = [
            'category'   => request('category'),
            'start_date' => request('start_date'),
            'end_date'   => request('end_date'),
        ];

        $expenses = Expense::query()
            ->when($filters['category'],   fn($q, $v) => $q->where('category', $v))
            ->when($filters['start_date'], fn($q, $v) => $q->whereDate('date', '>=', $v))
            ->when($filters['end_date'],   fn($q, $v) => $q->whereDate('date', '<=', $v))
            ->orderBy('date', 'desc')
            ->get();

        $categories = Expense::select('category')
            ->distinct()
            ->pluck('category');

        $summary = [
            'total'   => $expenses->count(),
            'amount'  => $expenses->sum('amount'),
            'highest' => $expenses->max('amount'),
            'average' => $expenses->avg('amount'),
        ];

        return view('reports.index', compact('expenses', 'categories', 'filters', 'summary'));
    }
}
