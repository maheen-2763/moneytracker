@extends('emails.layouts.base')

@section('content')

    {{-- Title --}}
    <div class="email-title">Your Weekly Summary 📊</div>
    <div class="email-subtitle">
        Hi <strong style="color:#0f172a;">{{ $user->name }}</strong>!
        Here's how your spending looked this week
        ({{ now()->startOfWeek()->format('d M') }} —
        {{ now()->endOfWeek()->format('d M Y') }}).
    </div>

    {{-- ── Stats Row ── --}}
    <div class="stat-row">
        <div class="stat-box">
            <div class="stat-label">This Week</div>
            <div class="stat-value" style="color:#6366f1;">
                ₹{{ number_format($data['this_week'], 0) }}
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Expenses</div>
            <div class="stat-value" style="color:#0f172a;">
                {{ $data['expense_count'] }}
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-label">This Month</div>
            <div class="stat-value" style="color:#22c55e;">
                ₹{{ number_format($data['this_month'], 0) }}
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Daily Avg</div>
            <div class="stat-value" style="color:#f59e0b;">
                ₹{{ number_format($data['daily_avg'], 0) }}
            </div>
        </div>
    </div>

    {{-- ── Top Category ── --}}
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

    {{-- ── Recent Expenses Table ── --}}
    @if (count($data['recent_expenses']) > 0)
        <div style="margin-top:24px;">
            <div style="font-weight:700; font-size:0.85rem;
                    color:#0f172a; margin-bottom:12px;">
                This Week's Expenses
            </div>

            <table style="width:100%; border-collapse:collapse;
                      font-size:0.8rem;">
                <thead>
                    <tr style="background:#f8fafc;
                           border-bottom:2px solid #e2e8f0;">
                        <th
                            style="padding:10px 12px; text-align:left;
                               font-weight:700; color:#64748b;
                               text-transform:uppercase;
                               font-size:0.68rem; letter-spacing:0.06em;">
                            Title
                        </th>
                        <th
                            style="padding:10px 12px; text-align:left;
                               font-weight:700; color:#64748b;
                               text-transform:uppercase;
                               font-size:0.68rem; letter-spacing:0.06em;">
                            Category
                        </th>
                        <th
                            style="padding:10px 12px; text-align:right;
                               font-weight:700; color:#64748b;
                               text-transform:uppercase;
                               font-size:0.68rem; letter-spacing:0.06em;">
                            Amount
                        </th>
                        <th
                            style="padding:10px 12px; text-align:right;
                               font-weight:700; color:#64748b;
                               text-transform:uppercase;
                               font-size:0.68rem; letter-spacing:0.06em;">
                            Date
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['recent_expenses'] as $expense)
                        <tr style="border-bottom:1px solid #f1f5f9;">
                            <td
                                style="padding:10px 12px;
                                   color:#0f172a; font-weight:600;">
                                {{ $expense->title }}
                            </td>
                            <td
                                style="padding:10px 12px;
                                   color:#64748b;
                                   text-transform:capitalize;">
                                {{ $expense->category }}
                            </td>
                            <td
                                style="padding:10px 12px; text-align:right;
                                   font-weight:700; color:#ef4444;">
                                ₹{{ number_format($expense->amount, 2) }}
                            </td>
                            <td
                                style="padding:10px 12px; text-align:right;
                                   color:#94a3b8;">
                                {{ \Carbon\Carbon::parse($expense->expense_date)->format('d M') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- ── Budget Status ── --}}
    @if (count($data['budgets']) > 0)
        <hr class="divider">

        <div style="font-weight:700; font-size:0.85rem;
                color:#0f172a; margin-bottom:16px;">
            Budget Status
        </div>

        @foreach ($data['budgets'] as $budget)
            @php
                $pct = $budget->percentUsed();
                $status = $budget->status();
                $colors = [
                    'safe' => '#22c55e',
                    'warning' => '#f59e0b',
                    'danger' => '#ef4444',
                ];
                $color = $colors[$status] ?? '#94a3b8';
            @endphp

            <div style="margin-bottom:16px;">
                <div
                    style="display:flex; justify-content:space-between;
                        align-items:center; margin-bottom:6px;">
                    <span
                        style="font-size:0.82rem; font-weight:700;
                             color:#0f172a; text-transform:capitalize;">
                        {{ $budget->category }}
                    </span>
                    <span
                        style="font-size:0.78rem; font-weight:700;
                             color:{{ $color }};">
                        {{ $pct }}% ·
                        ₹{{ number_format($budget->spentThisMonth(), 0) }}
                        / ₹{{ number_format($budget->amount, 0) }}
                    </span>
                </div>
                <div class="progress-wrap">
                    <div class="progress-bar"
                        style="width:{{ min($pct, 100) }}%;
                            background:{{ $color }};">
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <hr class="divider">

    {{-- ── CTAs ── --}}
    <div style="text-align:center;">
        <a href="{{ url('/reports') }}" class="email-btn">
            View Full Report →
        </a>
    </div>
    <div style="text-align:center; margin-top:12px;">
        <a href="{{ url('/dashboard') }}" class="email-btn-secondary">
            Go to Dashboard
        </a>
    </div>

@endsection
