@extends('emails.layouts.base')

@section('content')
    @php
        $catEmojis = [
            'food' => '🍔',
            'travel' => '✈️',
            'health' => '💊',
            'office' => '💼',
            'other' => '📦',
        ];
        $emoji = $catEmojis[$expense->category] ?? '📦';
    @endphp

    {{-- Title --}}
    <div class="email-title">Expense Recorded 🧾</div>
    <div class="email-subtitle">
        Hi <strong style="color:#0f172a;">{{ $user->name }}</strong>,
        your expense has been successfully recorded.
    </div>

    {{-- Receipt Card --}}
    <div style="background:#f8fafc; border:1px solid #e2e8f0;
            border-radius:16px; padding:24px; margin:20px 0;">

        {{-- Amount & Title --}}
        <div style="text-align:center; margin-bottom:20px;">
            <div style="font-size:2.5rem; margin-bottom:8px;">{{ $emoji }}</div>
            <div style="font-size:1.8rem; font-weight:800;
                    letter-spacing:-0.03em; color:#ef4444;">
                ₹{{ number_format($expense->amount, 2) }}
            </div>
            <div style="font-size:0.95rem; font-weight:700;
                    color:#0f172a; margin-top:4px;">
                {{ $expense->title }}
            </div>
            {{-- Category badge --}}
            <div
                style="display:inline-block; margin-top:8px;
                    background:#eef2ff; color:#6366f1;
                    padding:4px 12px; border-radius:99px;
                    font-size:0.72rem; font-weight:700;
                    text-transform:uppercase; letter-spacing:0.06em;">
                {{ ucfirst($expense->category) }}
            </div>
        </div>

        <hr style="border:none; border-top:1px solid #e2e8f0; margin:16px 0;">

        {{-- Details Table --}}
        <table style="width:100%; font-size:0.82rem; border-collapse:collapse;">
            <tr>
                <td style="color:#94a3b8; padding:6px 0;">
                    <span style="margin-right:6px;">📅</span> Date
                </td>
                <td style="text-align:right; font-weight:600; color:#0f172a;">
                    {{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}
                </td>
            </tr>
            <tr>
                <td style="color:#94a3b8; padding:6px 0;">
                    <span style="margin-right:6px;">🏷️</span> Category
                </td>
                <td
                    style="text-align:right; font-weight:600;
                       color:#0f172a; text-transform:capitalize;">
                    {{ $expense->category }}
                </td>
            </tr>
            @if ($expense->description)
                <tr>
                    <td style="color:#94a3b8; padding:6px 0;">
                        <span style="margin-right:6px;">📝</span> Notes
                    </td>
                    <td style="text-align:right; font-weight:600; color:#0f172a;">
                        {{ $expense->description }}
                    </td>
                </tr>
            @endif
            <tr>
                <td style="color:#94a3b8; padding:6px 0;">
                    <span style="margin-right:6px;">🕐</span> Recorded at
                </td>
                <td style="text-align:right; font-weight:600; color:#0f172a;">
                    {{ $expense->created_at->format('d M Y, h:i A') }}
                </td>
            </tr>
        </table>

    </div>

    {{-- Stat Row --}}
    <div class="stat-row">
        <div class="stat-box">
            <div class="stat-label">Amount</div>
            <div class="stat-value" style="color:#ef4444;">
                ₹{{ number_format($expense->amount, 0) }}
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Category</div>
            <div class="stat-value" style="font-size:1rem;">
                {{ ucfirst($expense->category) }}
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Date</div>
            <div class="stat-value" style="font-size:0.9rem;">
                {{ \Carbon\Carbon::parse($expense->expense_date)->format('d M') }}
            </div>
        </div>
    </div>

    {{-- Tip --}}
    <div class="alert-box success">
        <span class="alert-icon">💡</span>
        <div class="alert-text">
            <strong>Track your spending</strong>
            Visit your dashboard to see how this expense
            affects your monthly budget.
        </div>
    </div>

    <hr class="divider">

    {{-- CTAs --}}
    <div style="text-align:center;">
        <a href="{{ url('/dashboard') }}" class="email-btn">
            Go to Dashboard →
        </a>
    </div>
    <div style="text-align:center; margin-top:12px;">
        <a href="{{ url('/expenses') }}" class="email-btn-secondary">
            View All Expenses
        </a>
    </div>
@endsection
