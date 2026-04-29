@extends('layouts.app')
@section('title', 'My Expenses')

@section('content')

    <div class="page-heading d-flex justify-content-between align-items-center">
        <div>
            <h4>My Expenses</h4>
            <small>{{ $expenses->total() }} total records</small>
        </div>
        <a href="{{ route('expenses.create') }}" class="btn btn-primary d-md-none">
            <i class="bi bi-plus-lg"></i>
        </a>
    </div>

    {{-- Filter --}}
    <div class="filter-card mb-4">
        <form method="GET" action="{{ route('expenses.index') }}" class="row g-2 align-items-end">
            <div class="col-6 col-md-3">
                <label class="form-label">From</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-6 col-md-3">
                <label class="form-label">To</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-6 col-md-3">
                <label class="form-label">Category</label>
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach (['food', 'travel', 'office', 'health', 'other'] as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                            {{ ucfirst($cat) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-funnel"></i>
                    <span class="d-none d-md-inline ms-1">Filter</span>
                </button>
                <a href="{{ route('expenses.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
        </form>
    </div>

    {{-- Desktop: Table | Mobile: Cards --}}

    {{-- TABLE — hidden on mobile --}}
    <div class="table-card d-none d-md-block">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Amount</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses as $expense)
                    <tr>
                        <td>
                            <span
                                @if ($expense->notes) data-bs-toggle="tooltip"
                              data-bs-title="{{ $expense->notes }}" @endif>
                                {{ $expense->title }}
                                @if ($expense->notes)
                                    <i class="bi bi-info-circle text-muted ms-1" style="font-size:0.75rem"></i>
                                @endif
                            </span>
                        </td>
                        <td><span class="amount-text">₹{{ number_format($expense->amount, 2) }}</span></td>
                        <td><span class="cat-badge">{{ ucfirst($expense->category) }}</span></td>
                        <td class="text-muted">
                            <span data-bs-toggle="tooltip"
                                data-bs-title="{{ \Carbon\Carbon::parse($expense->date)->format('l, d M Y') }}">
                                {{ \Carbon\Carbon::parse($expense->date)->diffForHumans() }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('expenses.show', $expense) }}" class="action-link view"
                                data-bs-toggle="tooltip" data-bs-title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('expenses.edit', $expense) }}" class="action-link edit"
                                data-bs-toggle="tooltip" data-bs-title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('expenses.destroy', $expense) }}" class="d-inline"
                                onsubmit="return confirm('Delete this expense?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-link del border-0 bg-transparent"
                                    data-bs-toggle="tooltip" data-bs-title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            No expenses found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- CARDS — shown on mobile only --}}
    <div class="d-md-none">
        @forelse($expenses as $expense)
            <div class="expense-mobile-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fw-semibold">{{ $expense->title }}</div>
                        <div class="text-muted" style="font-size:0.78rem">
                            {{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}
                        </div>
                    </div>
                    <span class="amount-text">₹{{ number_format($expense->amount, 2) }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between mt-2">
                    <span class="cat-badge">{{ ucfirst($expense->category) }}</span>
                    <div class="d-flex gap-2">
                        <a href="{{ route('expenses.show', $expense) }}" class="action-link view"><i
                                class="bi bi-eye"></i></a>
                        <a href="{{ route('expenses.edit', $expense) }}" class="action-link edit"><i
                                class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('expenses.destroy', $expense) }}" class="d-inline"
                            onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="action-link del border-0 bg-transparent">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @if ($expense->notes)
                    <div class="expense-notes mt-1">
                        <i class="bi bi-chat-left-text me-1"></i>{{ $expense->notes }}
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center text-muted py-5">
                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                No expenses found.
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $expenses->withQueryString()->links() }}
    </div>

@endsection
