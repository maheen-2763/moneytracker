<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BudgetStoreRequest;
use App\Http\Requests\BudgetUpdateRequest;
use App\Http\Resources\BudgetResource;
use App\Models\Budget;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BudgetController extends Controller
{
    use AuthorizesRequests;
    // GET /api/budgets
    public function index(Request $request): AnonymousResourceCollection
    {
        $budgets = Budget::where('user_id', $request->user()->id)->get();

        return BudgetResource::collection($budgets);
    }

    // POST /api/budgets
    public function store(BudgetStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $budget = Budget::updateOrCreate(
            [
                'user_id'  => $request->user()->id,
                'category' => $data['category'],
            ],
            ['amount' => $data['amount']]
        );

        return response()->json([
            'message' => 'Budget saved successfully.',
            'budget'  => new BudgetResource($budget),
        ], 201);
    }

    // PUT /api/budgets/{budget}
    public function update(BudgetUpdateRequest $request, Budget $budget): JsonResponse
    {
        $this->authorize('update', $budget);

        $data = $request->validated();
        $budget->update($data);

        return response()->json([
            'message' => 'Budget updated successfully.',
            'budget'  => new BudgetResource($budget),
        ]);
    }

    // DELETE /api/budgets/{budget}
    public function destroy(Request $request, Budget $budget): JsonResponse
    {
        $this->authorize('delete', $budget);

        $budget->delete();

        return response()->json([
            'message' => 'Budget deleted successfully.',
        ]);
    }
}
