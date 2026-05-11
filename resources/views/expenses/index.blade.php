@extends('layouts.app')

@section('title', 'My Expenses')

@php
    $categories = [
        'food' => ['bg' => '#fef3c7', 'text' => '#92400e'],
        'travel' => ['bg' => '#dbeafe', 'text' => '#1d4ed8'],
        'office' => ['bg' => '#ede9fe', 'text' => '#6d28d9'],
        'health' => ['bg' => '#dcfce7', 'text' => '#166534'],
        'other' => ['bg' => '#e2e8f0', 'text' => '#475569'],
    ];
@endphp

@section('content')

    <div class="page-wrapper">

        {{-- HEADER --}}
        <div class="page-heading d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <h4>My Expenses</h4>
                <small>{{ $expenses->total() }} total records</small>
            </div>

            <a href="{{ route('expenses.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>
                Add Expense
            </a>

        </div>

        {{-- FILTER --}}
        <div class="filter-card mb-4">

            <div class="card-title-ui mb-2">Filter Expenses</div>
            <div class="card-subtitle-ui mb-3">Narrow down your records quickly</div>

            <form method="GET" action="{{ route('expenses.index') }}" class="row g-3 align-items-end">

                <div class="col-md-3">
                    <label class="form-label">From</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label">To</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Category</label>

                    <select name="category" class="form-select">
                        <option value="">All</option>

                        @foreach (array_keys($categories) as $cat)
                            <option value="{{ $cat }}" @selected(request('category') == $cat)>
                                {{ ucfirst($cat) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">

                    <button class="btn btn-primary w-100">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>

                    <a href="{{ route('expenses.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg"></i>
                    </a>

                </div>

            </form>
        </div>

        {{-- TABLE --}}
        <div class="table-card d-none d-md-block">

            <table class="table">

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
                        @php
                            $category = $expense->category ?? 'other';
                            $style = $categories[$category] ?? $categories['other'];
                            $date = $expense->date ? \Carbon\Carbon::parse($expense->date) : null;
                        @endphp

                        <tr>

                            {{-- TITLE --}}
                            <td>
                                <div class="fw-semibold">
                                    {{ $expense->title }}
                                </div>

                                @if ($expense->notes)
                                    <small class="text-muted">
                                        {{ Str::limit($expense->notes, 40) }}
                                    </small>
                                @endif
                            </td>

                            {{-- AMOUNT --}}
                            <td class="text-danger fw-bold">
                                ₹{{ number_format($expense->amount, 2) }}
                            </td>

                            {{-- CATEGORY --}}
                            <td>
                                <span class="px-2 py-1 rounded small"
                                    style="background: {{ $style['bg'] }}; color: {{ $style['text'] }};">
                                    {{ ucfirst($category) }}
                                </span>
                            </td>

                            {{-- DATE (SAFE FIX) --}}
                            <td class="text-muted small">
                                {{ $date ? $date->diffForHumans() : 'No date' }}
                            </td>

                            {{-- ACTIONS --}}
                            <td>
                                <div class="d-flex gap-2">

                                    <a href="{{ route('expenses.show', $expense) }}" class="text-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('expenses.edit', $expense) }}" class="text-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form method="POST" action="{{ route('expenses.destroy', $expense) }}"
                                        onsubmit="return confirm('Delete this expense?')">

                                        @csrf
                                        @method('DELETE')

                                        <button class="text-danger border-0 bg-transparent">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                No expenses found
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- MOBILE --}}
        <div class="d-md-none">

            @forelse($expenses as $expense)
                @php
                    $category = $expense->category ?? 'other';
                    $style = $categories[$category] ?? $categories['other'];
                    $date = $expense->date ? \Carbon\Carbon::parse($expense->date) : null;
                @endphp

                <div class="card mb-3 p-3">

                    <div class="d-flex justify-content-between">

                        <div>
                            <div class="fw-semibold">{{ $expense->title }}</div>
                            <small class="text-muted">
                                {{ $date ? $date->format('d M Y') : 'No date' }}
                            </small>
                        </div>

                        <div class="text-danger fw-bold">
                            ₹{{ number_format($expense->amount, 2) }}
                        </div>

                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-2">

                        <span class="px-2 py-1 rounded small"
                            style="background: {{ $style['bg'] }}; color: {{ $style['text'] }};">
                            {{ ucfirst($category) }}
                        </span>

                        <div class="d-flex gap-2">

                            <a href="{{ route('expenses.show', $expense) }}" class="text-primary">
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="{{ route('expenses.edit', $expense) }}" class="text-warning">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form method="POST" action="{{ route('expenses.destroy', $expense) }}">
                                @csrf
                                @method('DELETE')

                                <button class="text-danger border-0 bg-transparent">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>

                        </div>

                    </div>

                    @if ($expense->notes)
                        <div class="mt-2 small text-muted">
                            {{ $expense->notes }}
                        </div>
                    @endif

                </div>

            @empty

                <div class="text-center text-muted py-5">
                    No expenses found
                </div>
            @endforelse

        </div>

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $expenses->withQueryString()->links() }}
        </div>

    </div>

@endsection
