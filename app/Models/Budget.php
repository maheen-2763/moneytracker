<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;  // ← add

class Budget extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'category', 'amount'];

    protected $casts = [
        'amount'       => 'decimal:2'
    ];
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function scopeForUser(Builder $query, int|User $userId): Builder
    {
        $id = $userId instanceof User ? $userId->id : $userId;
        return $query->where('user_id', $id);
    }

    public function expenses()
    {
        return $this->hasManyThrough(Expense::class, User::class);
    }

    // How much spent this month in this category
    public function spentThisMonth(): float
    {
        return Expense::where('user_id', $this->user_id)
            ->where('category', $this->category)
            ->whereMonth('expense_date', now()->month)   // ← was 'date'
            ->whereYear('expense_date',  now()->year)    // ← was 'date'
            ->sum('amount');
    }
    // Percentage used (capped at 100)
    public function percentUsed(): int
    {
        if ($this->amount <= 0) return 0;
        return min(100, (int) round(($this->spentThisMonth() / $this->amount) * 100));
    }

    // Status label
    public function status(): string
    {
        $pct = $this->percentUsed();
        if ($pct >= 100) return 'danger';
        if ($pct >= 80)  return 'warning';
        return 'success';
    }
}
