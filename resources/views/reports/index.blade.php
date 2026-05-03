@extends('layouts.app')
@section('title', 'Reports')

@section('content')

    {{-- ── Page Heading ── --}}
    <div class="page-heading d-flex justify-content-between align-items-center">
        <div>
            <h4>📊 Reports</h4>
            <small>Filter your expenses and export them</small>
        </div>
    </div>

    {{-- ── Filter Card ── --}}
    <div class="filter-card mb-4">
        <form method="GET" action="{{ route('reports.index') }}" class="row g-3 align-items-end">

            <div class="col-md-3">
                <label class="form-label">Category</label>
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}" {{ $filters['category'] == $cat ? 'selected' : '' }}>
                            {{ ucfirst($cat) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">From Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ $filters['start_date'] }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">To Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ $filters['end_date'] }}">
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>

        </form>
    </div>

    {{-- ── Summary Cards ── --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card text-center">
                <div class="label">Total Expenses</div>
                <div class="value text-primary">{{ $summary['total'] }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card text-center">
                <div class="label">Total Amount</div>
                <div class="value" style="color:var(--danger)">
                    Rs.{{ number_format($summary['amount'], 2) }}
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card text-center">
                <div class="label">Highest</div>
                <div class="value" style="color:var(--warning)">
                    Rs.{{ number_format($summary['highest'], 2) }}
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card text-center">
                <div class="label">Average</div>
                <div class="value" style="color:var(--success)">
                    Rs.{{ number_format($summary['average'], 2) }}
                </div>
            </div>
        </div>
    </div>

    {{-- ── Export Buttons ── --}}
    @if ($expenses->count() > 0)
        <div class="d-flex gap-2 mb-4">
            <a href="{{ route('expenses.export.excel', request()->query()) }}" class="btn btn-success">
                <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
            </a>
            <a href="{{ route('expenses.export.pdf', request()->query()) }}" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
            </a>
        </div>
    @endif

    {{-- ── Results Table ── --}}
    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses as $i => $expense)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $expense->title }}</td>
                        <td><span class="cat-badge">{{ ucfirst($expense->category) }}</span></td>
                        <td><span class="amount-text">Rs.{{ number_format($expense->amount, 2) }}</span></td>
                        <td style="color:var(--text-muted)">
                            {{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4" style="color:var(--text-muted)">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            No expenses found for the selected filters.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
