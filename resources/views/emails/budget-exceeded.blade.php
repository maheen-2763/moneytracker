@extends('emails.layouts.base')

@section('content')
    @php
        $over = $spent - $budget->amount;
        $pct = min(100, round(($spent / $budget->amount) * 100));
        $catEmojis = [
            'food' => '🍔',
            'travel' => '✈️',
            'health' => '💊',
            'office' => '💼',
            'other' => '📦',
        ];
        $emoji = $catEmojis[$budget->category] ?? '📦';
    @endphp

    <div class="email-title">Budget Exceeded! 🚨</div>
    <div class="email-subtitle">
        Hi {{ $user->name }}, your <strong>{{ ucfirst($budget->category) }}</strong>
        budget has been exceeded this month.
    </div>

    <div class="alert-box danger">
        <span class="alert-icon">{{ $emoji }}</span>
        <div class="alert-text">
            <strong>{{ ucfirst($budget->category) }} — Over by ₹{{ number_format($over, 2) }}</strong>
            You've spent ₹{{ number_format($spent, 2) }} of your
            ₹{{ number_format($budget->amount, 2) }} monthly limit.
        </div>
    </div>

    {{-- Progress bar --}}
    <div style="margin: 1.25rem 0;">
        <div style="display:flex; justify-content:space-between;
                margin-bottom:.4rem; font-size:.78rem;">
            <span style="font-weight:700; color:#ef4444;">
                {{ $pct }}% used
            </span>
            <span style="color:#64748b;">
                ₹{{ number_format($spent, 0) }} /
                ₹{{ number_format($budget->amount, 0) }}
            </span>
        </div>
        <div class="progress-wrap">
            <div class="progress-bar" style="width:100%; background:#ef4444;"></div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stat-grid">
        <div class="stat-box">
            <div class="label">Spent</div>
            <div class="value" style="color:#ef4444;">
                ₹{{ number_format($spent, 0) }}
            </div>
        </div>
        <div class="stat-box">
            <div class="label">Over Budget</div>
            <div class="value" style="color:#ef4444;">
                ₹{{ number_format($over, 0) }}
            </div>
        </div>
    </div>

    <div class="alert-box warning">
        <span class="alert-icon">💡</span>
        <div class="alert-text">
            <strong>Tip: Review your spending</strong>
            Consider reviewing your {{ $budget->category }} expenses
            or increasing your budget limit for next month.
        </div>
    </div>

    <hr class="divider">

    <div style="text-align:center;">
        <a href="{{ url('/budgets') }}" class="email-btn">
            Review Budget →
        </a>
    </div>
@endsection
