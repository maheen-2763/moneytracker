<?php

// app/Http/Controllers/ExpenseController.php
namespace App\Http\Controllers;

use App\Http\Requests\{StoreExpenseRequest, UpdateExpenseRequest};
use App\Models\Expense;
use App\Services\ExpenseService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\View\View;
use App\Models\Budget;
use App\Notifications\BudgetExceeded;
use Illuminate\Support\Facades\Auth;
use App\Mail\BudgetExceededMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExpenseReceiptMail;


class ExpenseController extends Controller
{
    use AuthorizesRequests;


    public function __construct(private ExpenseService $service) {}

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
        $data = $request->validated();

        $expense = $this->service->create(
            $request->user()->id,
            $data,
            $request->file('receipt')
        );

        $this->checkBudget($data['category']);

        sleep(1); // Simulate processing delay for better UX with toast notifications
        Mail::to($request->user()->email)
            ->queue(new ExpenseReceiptMail($request->user(), $expense));

        return redirect()->route('expenses.index')
            ->with('toast_success', 'Expense added successfully!');

        return back()->with('toast_error', 'Something went wrong. Please try again.');
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

        $data = $request->validated();

        $this->service->update(
            $expense,
            $data,
            $request->file('receipt')
        );

        $this->checkBudget($data['category']);

        return redirect()->route('expenses.index')
            ->with('toast_success', 'Expense updated successfully!');
    }

    public function destroy(Expense $expense): RedirectResponse
    {
        $this->authorize('delete', $expense);

        $this->service->delete($expense);

        return redirect()->route('expenses.index')
            ->with('toast_success', 'Expense deleted.');

        return back()->with('toast_error', 'Failed to delete expense.');
    }


    private function checkBudget(string $category): void
    {
        $budget = Budget::forUser(Auth::id())
            ->where('category', $category)
            ->first();

        if (!$budget) return;

        $spent = $budget->spentThisMonth();

        if ($spent >= $budget->amount) {

            // ← Query DB directly instead of collection filter
            $alreadyNotified = Auth::user()
                ->notifications()
                ->where('type', BudgetExceeded::class)
                ->whereNull('read_at')
                ->whereJsonContains('data->category', $category)
                ->exists();

            if (!$alreadyNotified) {
                $user = Auth::user();

                // DB notification (bell icon)
                $user->notify(new BudgetExceeded($budget, $spent));

                Mail::to($user->email)
                    ->queue(new BudgetExceededMail($user, $budget, $spent));
            }
        }
    }
}
