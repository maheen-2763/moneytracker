<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::withCount('expenses')
            ->withSum('expenses', 'amount')
            ->when(
                $request->search,
                fn($q, $v) =>
                $q->where('name', 'like', "%$v%")
                    ->orWhere('email', 'like', "%$v%")
            )
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->loadCount('expenses');
        $user->loadSum('expenses', 'amount');

        $expenses = $user->expenses()
            ->latest('expense_date')
            ->paginate(10);

        $budgets = $user->budgets()->get();

        return view('admin.users.show', compact('user', 'expenses', 'budgets'));
    }

    public function ban(User $user)
    {
        // Soft approach — delete all tokens
        $user->tokens()->delete();
        $user->update(['email_verified_at' => null]);

        return back()->with('success', "User {$user->name} has been banned.");
    }

    public function destroy(User $user)
    {
        $user->expenses()->delete();
        $user->budgets()->delete();
        $user->notifications()->delete();
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
