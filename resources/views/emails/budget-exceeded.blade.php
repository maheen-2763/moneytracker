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

    {{-- Title --}}
    <div class="email-title">Budget Exceeded! 🚨</div>

    {{-- Subtitle --}}
    <div class="email-subtitle">
        Hi <strong style="color:#0f172a;">{{ $user->name }}</strong>, your
        <strong style="color:#0f172a;">{{ ucfirst($budget->category) }}</strong>
        budget has been exceeded this month.
    </div>

    {{-- Danger Alert --}}
    <div class="alert-box danger">
        <span class="alert-icon">{{ $emoji }}</span>
        <div class="alert-text">
            <strong>{{ ucfirst($budget->category) }} — Over by ₹{{ number_format($over, 2) }}</strong>
            You've spent ₹{{ number_format($spent, 2) }} of your
            ₹{{ number_format($budget->amount, 2) }} monthly limit.
        </div>
    </div>

    {{-- Progress Bar --}}
    <div style="margin: 20px 0;">
        <div style="display:flex; justify-content:space-between;
                align-items:center; margin-bottom:6px;">
            <span style="font-size:0.78rem; font-weight:700; color:#ef4444;">
                {{ $pct }}% used
            </span>
            <span style="font-size:0.78rem; color:#64748b;">
                ₹{{ number_format($spent, 0) }} / ₹{{ number_format($budget->amount, 0) }}
            </span>
        </div>
        <div class="progress-wrap">
            <div class="progress-bar" style="width:100%; background:#ef4444;">
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stat-row">
        <div class="stat-box">
            <div class="stat-label">Spent</div>
            <div class="stat-value" style="color:#ef4444;">
                ₹{{ number_format($spent, 0) }}
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Budget</div>
            <div class="stat-value" style="color:#0f172a;">
                ₹{{ number_format($budget->amount, 0) }}
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Over By</div>
            <div class="stat-value" style="color:#ef4444;">
                ₹{{ number_format($over, 0) }}
            </div>
        </div>
    </div>

    {{-- Tip Alert --}}
    <div class="alert-box warning">
        <span class="alert-icon">💡</span>
        <div class="alert-text">
            <strong>Tip: Review your spending</strong>
            Consider reviewing your {{ $budget->category }} expenses
            or increasing your budget limit for next month.
        </div>
    </div>

    <hr class="divider">

    {{-- CTA --}}
    <div style="text-align:center;">
        <a href="{{ url('/budgets') }}" class="email-btn">
            Review Budget →
        </a>
    </div>

    <div style="text-align:center; margin-top:12px;">
        <a href="{{ url('/expenses') }}" class="email-btn-secondary">
            View Expenses
        </a>
    </div>
@endsection
