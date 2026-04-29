<?php

namespace App\Http\Controllers;

use App\Exports\ExpensesExport;
use App\Models\Expense;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    // Shared: build filters from request
    private function getFilters(): array
    {
        return [
            'category'   => request('category'),
            'start_date' => request('start_date'),
            'end_date'   => request('end_date'),
        ];
    }

    // Shared: build filtered query
    private function filteredExpenses()
    {
        $filters = $this->getFilters();

        return Expense::query()
            ->when($filters['category'],   fn($q, $v) => $q->where('category', $v))
            ->when($filters['start_date'], fn($q, $v) => $q->whereDate('date', '>=', $v))
            ->when($filters['end_date'],   fn($q, $v) => $q->whereDate('date', '<=', $v))
            ->orderBy('date', 'desc')
            ->get();
    }

    // ── Export to Excel ──────────────────────────────────
    public function excel()
    {
        $filename = 'expenses-' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(
            new ExpensesExport($this->getFilters()),
            $filename
        );
    }

    // ── Export to PDF ────────────────────────────────────
    public function pdf()
    {
        $expenses = $this->filteredExpenses();
        $filters  = $this->getFilters();

        $pdf = Pdf::loadView('exports.expenses-pdf', compact('expenses', 'filters'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('expenses-' . now()->format('Y-m-d') . '.pdf');
    }
}
