<?php

namespace App\Exports;

use App\Models\Expense;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExpensesExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    ShouldAutoSize
{
    protected $filters;

    // Accept filters so export respects the active search/filter
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        return Expense::query()
            ->when($this->filters['category'] ?? null, fn($q, $v) => $q->where('category', $v))
            ->when($this->filters['start_date'] ?? null, fn($q, $v) => $q->whereDate('date', '>=', $v))
            ->when($this->filters['end_date'] ?? null,   fn($q, $v) => $q->whereDate('date', '<=', $v))
            ->orderBy('date', 'desc')
            ->get();
    }

    // Column headers
    public function headings(): array
    {
        return ['#', 'Title', 'Category', 'Amount (₹)', 'Date', 'Notes'];
    }

    // Map each row
    public function map($expense): array
    {
        static $index = 0;
        $index++;

        return [
            $index,
            $expense->title,
            ucfirst($expense->category),
            number_format($expense->amount, 2),
            \Carbon\Carbon::parse($expense->date)->format('d M Y'),
            $expense->notes ?? '—',
        ];
    }

    // Style the header row
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType'   => 'solid',
                    'startColor' => ['argb' => 'FF6366F1'], // indigo
                ],
            ],
        ];
    }
}
