@extends('emails.layouts.base')

@section('content')
    <div class="email-title">Your Weekly Summary 📊</div>
    <div class="email-subtitle">
        Hi {{ $user->name }}! Here's how your spending looked
        this week ({{ now()->startOfWeek()->format('d M') }}
        — {{ now()->endOfWeek()->format('d M Y') }}).
    </div>

    {{-- Weekly stats --}}
    <div class="stat-grid">
        <div class="stat-box">
            <div class="label">This Week</div>
            <div class="value" style="color:#6366f1;">
                ₹{{ number_format($data['this_week'], 0) }}
            </div>
        </div>
        <div class="stat-box">
            <div class="label">Expenses</div>
            <div class="value" style="color:#0f172a;">
                {{ $data['expense_count'] }}
            </div>
        </div>
        <div class="stat-box">
            <div class="label">This Month</div>
            <div class="value" style="color:#22c55e;">
                ₹{{ number_format($data['this_month'], 0) }}
            </div>
        </div>
        <div class="stat-box">
            <div class="label">Daily Average</div>
            <div class="value" style="color:#f59e0b;">
                ₹{{ number_format($data['daily_avg'], 0) }}
            </div>
        </div>
    </div>

    {{-- Top category this week --}}
    @if ($data['top_category'])
        <div class="alert-box" style="background:#eef2ff; border:1px solid #c7d2fe;">
            <span class="alert-icon">🏆</span>
            <div class="alert-text" style="color:#3730a3;">
                <strong>Highest Spending Category</strong>
                {{ ucfirst($data['top_category']->category) }} —
                ₹{{ number_format($data['top_category']->total, 0) }}
                ({{ $data['top_category']->count }} expenses)
            </div>
        </div>
    @endif

    {{-- Recent expenses --}}
    @if (count($data['recent_expenses']) > 0)
        <div style="margin-top:1.25rem;">
            <div style="font-weight:700; font-size:.85rem;
                color:#0f172a; margin-bottom:.75rem;">
                This Week's Expenses
            </div>
            <table class="expense-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['recent_expenses'] as $expense)
                        <tr>
                            <td>{{ $expense->title }}</td>
                            <td style="text-transform:capitalize;">
                                {{ $expense->category }}
                            </td>
                            <td class="amount">
                                ₹{{ number_format($expense->amount, 2) }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($expense->expense_date)->format('d M') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- Budget status --}}
    @if (count($data['budgets']) > 0)
        <hr class="divider">
        <div style="font-weight:700; font-size:.85rem;
            color:#0f172a; margin-bottom:.75rem;">
            Budget Status
        </div>
        @foreach ($data['budgets'] as $budget)
            @php
                $pct = $budget->percentUsed();
                $status = $budget->status();
                $colors = [
                    'success' => '#22c55e',
                    'warning' => '#f59e0b',
                    'danger' => '#ef4444',
                ];
                $color = $colors[$status];
            @endphp
            <div style="margin-bottom:.85rem;">
                <div
                    style="display:flex; justify-content:space-between;
                margin-bottom:.3rem; font-size:.78rem;">
                    <span style="font-weight:600; text-transform:capitalize;">
                        {{ $budget->category }}
                    </span>
                    <span style="color:{{ $color }}; font-weight:700;">
                        {{ $pct }}% —
                        ₹{{ number_format($budget->spentThisMonth(), 0) }}
                        / ₹{{ number_format($budget->amount, 0) }}
                    </span>
                </div>
                <div class="progress-wrap">
                    <div class="progress-bar"
                        style="width:{{ $pct }}%;
                    background:{{ $color }};"></div>
                </div>
            </div>
        @endforeach
    @endif

    <hr class="divider">

    <div style="text-align:center;">
        <a href="{{ url('/reports') }}" class="email-btn">
            View Full Report →
        </a>
    </div>
@endsection
