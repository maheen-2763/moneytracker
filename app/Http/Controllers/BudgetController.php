<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        // Default categories — always available
        $defaultCategories = collect([
            'food',
            'travel',
            'health',
            'office',
            'shopping',
            'entertainment',
            'other'
        ]);

        $budgets = Budget::forUser(Auth::id())->get();

        // Merge expense categories + defaults so dropdown is never empty
        $allCategories = Expense::forUser(Auth::id())
            ->select('category')
            ->distinct()
            ->pluck('category')
            ->merge($defaultCategories)   // ← add defaults
            ->unique()
            ->sort()
            ->values();

        $budgetedCategories = $budgets->pluck('category');
        $unbudgeted = $allCategories->diff($budgetedCategories)->values();

        return view('budgets.index', compact('budgets', 'unbudgeted'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => ['required', 'string'],
            'amount'   => ['required', 'numeric', 'min:1'],
        ]);

        Budget::updateOrCreate(
            [
                'user_id'  => Auth::id(),
                'category' => ($request->category)],
            ['amount' => $request->amount]
        );

        return back()->with('success', "Budget set for {$request->category}!");
    }

    public function update(Request $request, Budget $budget)
    {
        $this->authorize('update', $budget);

        $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
        ]);

        $budget->update(['amount' => $request->amount]);

        return back()->with('success', 'Budget updated!');
    }

    public function destroy(Budget $budget)
    {
        $this->authorize('delete', $budget);

        $budget->delete();

        return back()->with('success', 'Budget removed.');
    }
}
