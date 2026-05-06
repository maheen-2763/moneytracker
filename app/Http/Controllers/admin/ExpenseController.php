<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $expenses = Expense::with('user')
            ->when(
                $request->search,
                fn($q, $v) =>
                $q->where('title', 'like', "%$v%")
            )
            ->when(
                $request->category,
                fn($q, $v) =>
                $q->where('category', $v)
            )
            ->when(
                $request->user_id,
                fn($q, $v) =>
                $q->where('user_id', $v)
            )
            ->latest('expense_date')
            ->paginate(15);

        $categories = Expense::distinct()->pluck('category');
        $users      = \App\Models\User::orderBy('name')->get();

        return view('admin.expenses.index', compact('expenses', 'categories', 'users'));
    }

    public function destroy(Expense $expense)
    {
        $expense->forceDelete();

        return back()->with('success', 'Expense permanently deleted.');
    }
}
