<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Http\Requests\{StoreFormRequest, UpdateFormRequest};
use App\Models\Expense;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ExpenseController extends Controller
{
    use AuthorizesRequests;
    // GET /api/expenses
    public function index(Request $request): AnonymousResourceCollection
    {
        $expenses = Expense::where('user_id', $request->user()->id)
            ->when($request->category,   fn($q, $v) => $q->where('category', $v))
            ->when($request->start_date, fn($q, $v) => $q->whereDate('expense_date', '>=', $v))
            ->when($request->end_date,   fn($q, $v) => $q->whereDate('expense_date', '<=', $v))
            ->orderBy('expense_date', 'desc')
            ->paginate(15);

        return ExpenseResource::collection($expenses);
    }

    // POST /api/expenses
    public function store(StoreFormRequest $request): JsonResponse
    {
        $data = $request->validated();

        $expense = Expense::create([
            ...$data,
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'message' => 'Expense created successfully.',
            'expense' => new ExpenseResource($expense),
        ], 201);
    }

    // GET /api/expenses/{expense}
    public function show(Request $request, Expense $expense): JsonResponse
    {
        $this->authorize('view', $expense);

        return response()->json([
            'expense' => new ExpenseResource($expense),
        ]);
    }

    // PUT /api/expenses/{expense}
    public function update(UpdateFormRequest $request, Expense $expense): JsonResponse
    {
        $this->authorize('update', $expense);

        $data = $request->validated();

        $expense->update($data);

        return response()->json([
            'message' => 'Expense updated successfully.',
            'expense' => new ExpenseResource($expense),
        ]);
    }

    // DELETE /api/expenses/{expense}
    public function destroy(Request $request, Expense $expense): JsonResponse
    {
        $this->authorize('delete', $expense);
        $expense->delete();

        return response()->json([
            'message' => 'Expense deleted successfully.',
        ]);
    }
}
