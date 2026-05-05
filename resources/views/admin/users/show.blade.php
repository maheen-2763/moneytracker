@extends('admin.layouts.app')
@section('title', 'User: ' . $user->name)

@section('content')

    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary mb-4">
        ← Back to Users
    </a>

    <div class="row g-4">

        {{-- User card --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-4" style="border-radius:16px;">
                <img src="{{ $user->avatarUrl() }}" class="rounded-circle mx-auto mb-3" width="80" height="80"
                    style="object-fit:cover; border:3px solid #6366f1;">
                <h5 class="fw-bold mb-0">{{ $user->name }}</h5>
                <p class="text-muted small">{{ $user->email }}</p>
                @if ($user->bio)
                    <p class="small text-muted bg-light rounded p-2">
                        {{ $user->bio }}
                    </p>
                @endif

                <div class="row g-2 mt-2">
                    <div class="col-4 text-center">
                        <div class="fw-bold">{{ $user->expenses_count }}</div>
                        <div class="text-muted" style="font-size:.7rem">Expenses</div>
                    </div>
                    <div class="col-4 text-center">
                        <div class="fw-bold text-danger">
                            ₹{{ number_format($user->expenses_sum_amount ?? 0, 0) }}
                        </div>
                        <div class="text-muted" style="font-size:.7rem">Spent</div>
                    </div>
                    <div class="col-4 text-center">
                        <div class="fw-bold">{{ $budgets->count() }}</div>
                        <div class="text-muted" style="font-size:.7rem">Budgets</div>
                    </div>
                </div>

                <div class="mt-3 d-grid gap-2">
                    <form method="POST" action="{{ route('admin.users.ban', $user) }}">
                        @csrf
                        <button class="btn btn-warning btn-sm w-100" onclick="return confirm('Ban this user?')">
                            <i class="bi bi-slash-circle me-1"></i> Ban User
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm w-100"
                            onclick="return confirm('Delete this user permanently?')">
                            <i class="bi bi-trash me-1"></i> Delete User
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Expenses --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius:14px; overflow:hidden;">
                <div class="card-body p-0">
                    <div class="px-4 py-3 border-bottom">
                        <h6 class="fw-bold mb-0">Recent Expenses</h6>
                    </div>
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenses as $expense)
                                <tr>
                                    <td style="font-size:.85rem">{{ $expense->title }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            {{ ucfirst($expense->category) }}
                                        </span>
                                    </td>
                                    <td class="text-danger fw-bold" style="font-size:.85rem">
                                        ₹{{ number_format($expense->amount, 2) }}
                                    </td>
                                    <td class="text-muted" style="font-size:.82rem">
                                        {{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        No expenses yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-3 d-flex justify-content-center">
                {{ $expenses->links() }}
            </div>
        </div>
    </div>

@endsection
