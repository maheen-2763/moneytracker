<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes, Builder};
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

  public function scopeForUser(Builder $query, int $userId): Builder
{
    return $query->where('user_id', $userId);
    
}

    public function scopeInDateRange(Builder $query, ?string $from, ?string $to): Builder
{
    return $query
        ->when($from, fn($q) => $q->whereDate('expense_date', '>=', $from))
        ->when($to,   fn($q) => $q->whereDate('expense_date', '<=', $to));
}

  public function scopeByCategory(Builder $query, ?string $category) : Builder
    {
        return $query->when($category, fn($q) => $q->where('category', $category));
    }
}
