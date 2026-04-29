<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Expense extends Model
{
    protected $fillable = [
    'user_id', 'title', 'description',
    'amount', 'category', 'expense_date', 'receipt_path',
];
    protected $casts = [
    'amount'       => 'decimal:2',
    'expense_date' => 'date',
];

public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}

public function scopeForUser($query, int $userId)
{
    return $query->where('user_id', $userId);
}
    public function scopeInDateRange($query, ?string $from, ?string $to)
{
    return $query
        ->when($from, fn($q) => $q->whereDate('expense_date', '>=', $from))
        ->when($to,   fn($q) => $q->whereDate('expense_date', '<=', $to));
}

  public function scopeByCategory($query, ?string $category)
    {
        return $query->when($category, fn($q) => $q->where('category', $category));
    }
}
