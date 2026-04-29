<?php

namespace App\Services;

use App\Models\Expense;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class ExpenseService
{
    public function list(int $userId, array $filters): LengthAwarePaginator
    {
        return Expense::forUser($userId)
            ->inDateRange($filters['from'] ?? null, $filters['to'] ?? null)
            ->byCategory($filters['category'] ?? null)
            ->orderByDesc('expense_date')
            ->paginate(15);
    }

    public function create(int $userId, array $data, ?UploadedFile $receipt): Expense
    {
        $data['user_id']      = $userId;
        $data['receipt_path'] = $receipt?->store('receipts', 'private');
        return Expense::create($data);
    }

    public function update(Expense $expense, array $data, ?UploadedFile $receipt): Expense
    {
        if ($receipt) {
            Storage::disk('private')->delete($expense->receipt_path);
            $data['receipt_path'] = $receipt->store('receipts', 'private');
        }
        $expense->update($data);
        return $expense->fresh();
    }

    public function delete(Expense $expense): void
    {
        $expense->delete();
    }
}