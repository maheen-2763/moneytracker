@extends('admin.layouts.app')
@section('title', 'All Expenses')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 style="font-weight:800; letter-spacing:-0.03em; color:#0f172a; margin:0;">
                All Expenses
            </h4>
            <small class="text-muted">{{ $expenses->total() }} total records</small>
        </div>
    </div>

    {{-- ── Filters ── --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius:14px;">
        <div class="card-body py-3">
            <form method="GET" class="row g-2 align-items-end">

                <div class="col-md-4">
                    <input type="text" name="search" class="form-control form-control-sm"
                        placeholder="Search by title..." value="{{ request('search') }}">
                </div>

                <div class="col-md-2">
                    <select name="category" class="form-select form-select-sm">
                        <option value="">All Categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                {{ ucfirst($cat) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="user_id" class="form-select form-select-sm">
                        <option value="">All Users</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <input type="date" name="start_date" class="form-control form-control-sm"
                        value="{{ request('start_date') }}" placeholder="From">
                </div>

                <div class="col-md-2">
                    <input type="date" name="end_date" class="form-control form-control-sm"
                        value="{{ request('end_date') }}" placeholder="To">
                </div>

                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-primary px-4">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.expenses.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-x-lg me-1"></i> Clear
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- ── Table ── --}}
    <div class="card border-0 shadow-sm" style="border-radius:14px; overflow:hidden;">
        <table class="table table-hover mb-0">
            <thead style="background:#f8fafc;">
                <tr>
                    <th
                        style="padding:.85rem 1.25rem; font-size:.7rem; font-weight:700;
                           text-transform:uppercase; letter-spacing:.08em;
                           color:#94a3b8; border-bottom:1px solid #e2e8f0;">
                        User
                    </th>
                    <th
                        style="padding:.85rem 1rem; font-size:.7rem; font-weight:700;
                           text-transform:uppercase; letter-spacing:.08em;
                           color:#94a3b8; border-bottom:1px solid #e2e8f0;">
                        Title
                    </th>
                    <th
                        style="padding:.85rem 1rem; font-size:.7rem; font-weight:700;
                           text-transform:uppercase; letter-spacing:.08em;
                           color:#94a3b8; border-bottom:1px solid #e2e8f0;">
                        Category
                    </th>
                    <th
                        style="padding:.85rem 1rem; font-size:.7rem; font-weight:700;
                           text-transform:uppercase; letter-spacing:.08em;
                           color:#94a3b8; border-bottom:1px solid #e2e8f0;">
                        Amount
                    </th>
                    <th
                        style="padding:.85rem 1rem; font-size:.7rem; font-weight:700;
                           text-transform:uppercase; letter-spacing:.08em;
                           color:#94a3b8; border-bottom:1px solid #e2e8f0;">
                        Date
                    </th>
                    <th
                        style="padding:.85rem 1rem; font-size:.7rem; font-weight:700;
                           text-transform:uppercase; letter-spacing:.08em;
                           color:#94a3b8; border-bottom:1px solid #e2e8f0;">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $catColors = [
                        'food' => ['bg' => '#fef9c3', 'color' => '#854d0e'],
                        'travel' => ['bg' => '#e0f2fe', 'color' => '#075985'],
                        'health' => ['bg' => '#dcfce7', 'color' => '#166534'],
                        'office' => ['bg' => '#ede9fe', 'color' => '#5b21b6'],
                        'other' => ['bg' => '#f1f5f9', 'color' => '#475569'],
                    ];
                @endphp

                @forelse($expenses as $expense)
                    @php $cat = $catColors[$expense->category] ?? $catColors['other']; @endphp
                    <tr style="border-bottom:1px solid #f8fafc;">
                        <td style="padding:.85rem 1.25rem; vertical-align:middle;">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $expense->user->avatarUrl() }}" class="rounded-circle" width="30"
                                    height="30" style="object-fit:cover; border:2px solid #e2e8f0;">
                                <div>
                                    <div style="font-size:.82rem; font-weight:700; color:#0f172a;">
                                        {{ $expense->user->name }}
                                    </div>
                                    <div style="font-size:.72rem; color:#94a3b8;">
                                        {{ $expense->user->email }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td style="padding:.85rem 1rem; vertical-align:middle;">
                            <div
                                style="font-size:.875rem; font-weight:600; color:#0f172a;
                                max-width:160px; white-space:nowrap;
                                overflow:hidden; text-overflow:ellipsis;">
                                {{ $expense->title ?: '—' }}
                            </div>
                            @if ($expense->description)
                                <div
                                    style="font-size:.72rem; color:#94a3b8;
                                    max-width:160px; white-space:nowrap;
                                    overflow:hidden; text-overflow:ellipsis;">
                                    {{ $expense->description }}
                                </div>
                            @endif
                        </td>
                        <td style="padding:.85rem 1rem; vertical-align:middle;">
                            <span
                                style="display:inline-flex; align-items:center;
                                 padding:.2rem .65rem; border-radius:20px;
                                 font-size:.72rem; font-weight:700;
                                 background:{{ $cat['bg'] }};
                                 color:{{ $cat['color'] }};">
                                {{ ucfirst($expense->category) }}
                            </span>
                        </td>
                        <td style="padding:.85rem 1rem; vertical-align:middle;">
                            <span
                                style="font-weight:800; color:#ef4444;
                                 font-size:.875rem; font-variant-numeric:tabular-nums;">
                                ₹{{ number_format($expense->amount, 2) }}
                            </span>
                        </td>
                        <td
                            style="padding:.85rem 1rem; vertical-align:middle;
                           color:#64748b; font-size:.82rem;">
                            {{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}
                        </td>
                        <td style="padding:.85rem 1rem; vertical-align:middle;">
                            <form method="POST" action="{{ route('admin.expenses.destroy', $expense) }}"
                                onsubmit="return confirm('Permanently delete this expense?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip"
                                    data-bs-title="Delete permanently">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            No expenses found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $expenses->withQueryString()->links() }}
    </div>

@endsection

@push('scripts')
    <script>
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
            .forEach(el => new bootstrap.Tooltip(el));
    </script>
@endpush
