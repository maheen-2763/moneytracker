@extends('layouts.app')
@section('title', 'Reports')

@section('content')

    {{-- ── Page Heading ── --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-0">📊 Reports</h4>
            <small class="text-muted">Filter your expenses and export them</small>
        </div>
    </div>

    {{-- ── Filter Card ── --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('reports.index') }}" class="row g-3 align-items-end">

                {{-- Category --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Category</label>
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" {{ $filters['category'] == $cat ? 'selected' : '' }}>
                                {{ ucfirst($cat) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Start Date --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">From Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $filters['start_date'] }}">
                </div>

                {{-- End Date --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">To Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $filters['end_date'] }}">
                </div>

                {{-- Actions --}}
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
    </div>

    {{-- ── Summary Cards ── --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <div class="text-muted small">Total Expenses</div>
                <div class="fw-bold fs-4 text-primary">{{ $summary['total'] }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <div class="text-muted small">Total Amount</div>
                <div class="fw-bold fs-4 text-danger">Rs.{{ number_format($summary['amount'], 2) }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <div class="text-muted small">Highest</div>
                <div class="fw-bold fs-4 text-warning">Rs.{{ number_format($summary['highest'], 2) }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <div class="text-muted small">Average</div>
                <div class="fw-bold fs-4 text-success">Rs.{{ number_format($summary['average'], 2) }}</div>
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
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
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
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ ucfirst($expense->category) }}
                                </span>
                            </td>
                            <td class="text-danger fw-semibold">
                                Rs.{{ number_format($expense->amount, 2) }}
                            </td>
                            <td class="text-muted">
                                {{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                No expenses found for the selected filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
