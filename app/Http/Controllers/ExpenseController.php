<?php

// app/Http/Controllers/ExpenseController.php
namespace App\Http\Controllers;

use App\Http\Requests\{StoreExpenseRequest, UpdateExpenseRequest};
use App\Models\Expense;
use App\Services\ExpenseService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\View\View;

class ExpenseController extends Controller
{
    use AuthorizesRequests;
    
   
    public function __construct(private ExpenseService $service)
    {}

    public function index(Request $request): View
    {
        $expenses = $this->service->list(
            $request->user()->id,
            $request->only(['from', 'to', 'category'])
        );

        return view('expenses.index', compact('expenses'));
    }

    public function create(): View
    {
        return view('expenses.create');
    }

    public function store(StoreExpenseRequest $request): RedirectResponse
    {
        $this->service->create(
            $request->user()->id,
            $request->validated(),
            $request->file('receipt')
        );

        return redirect()->route('expenses.index')
            ->with('success', 'Expense added successfully.');
    }

    public function show(Expense $expense): View
    {
        $this->authorize('view', $expense);

        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense): View
    {
        $this->authorize('update', $expense);

        return view('expenses.edit', compact('expense'));
    }

    public function update(UpdateExpenseRequest $request, Expense $expense): RedirectResponse
    {
        $this->authorize('update', $expense);

        $this->service->update(
            $expense,
            $request->validated(),
            $request->file('receipt')
        );

        return redirect()->route('expenses.index')
            ->with('success', 'Expense updated.');
    }

    public function destroy(Expense $expense): RedirectResponse
    {
        $this->authorize('delete', $expense);

        $this->service->delete($expense);

        return redirect()->route('expenses.index')
            ->with('success', 'Expense deleted.');
    }
}
