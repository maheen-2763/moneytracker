@extends('emails.layouts.base')

@section('content')
    <div class="email-title">Welcome, {{ $user->name }}! 👋</div>
    <div class="email-subtitle">
        Your MoneyTracker account is ready. Here's what you can
        do to get started:
    </div>

    <div class="alert-box success">
        <span class="alert-icon">✅</span>
        <div class="alert-text">
            <strong>Account Created Successfully</strong>
            You're all set! Start tracking your expenses today.
        </div>
    </div>

    {{-- Getting started steps --}}
    <div style="margin: 1.5rem 0;">

        <div style="display:flex; gap:.75rem; margin-bottom:1rem;
                align-items:flex-start;">
            <div
                style="width:28px; height:28px; background:#eef2ff;
                    border-radius:50%; display:flex; align-items:center;
                    justify-content:center; font-weight:800;
                    color:#6366f1; font-size:.82rem; flex-shrink:0;">
                1
            </div>
            <div>
                <div
                    style="font-weight:700; font-size:.875rem;
                        color:#0f172a; margin-bottom:.15rem;">
                    Add your first expense
                </div>
                <div style="font-size:.78rem; color:#64748b;">
                    Track where your money goes by category
                </div>
            </div>
        </div>

        <div style="display:flex; gap:.75rem; margin-bottom:1rem;
                align-items:flex-start;">
            <div
                style="width:28px; height:28px; background:#eef2ff;
                    border-radius:50%; display:flex; align-items:center;
                    justify-content:center; font-weight:800;
                    color:#6366f1; font-size:.82rem; flex-shrink:0;">
                2
            </div>
            <div>
                <div
                    style="font-weight:700; font-size:.875rem;
                        color:#0f172a; margin-bottom:.15rem;">
                    Set monthly budgets
                </div>
                <div style="font-size:.78rem; color:#64748b;">
                    Get alerts before you overspend
                </div>
            </div>
        </div>

        <div style="display:flex; gap:.75rem; align-items:flex-start;">
            <div
                style="width:28px; height:28px; background:#eef2ff;
                    border-radius:50%; display:flex; align-items:center;
                    justify-content:center; font-weight:800;
                    color:#6366f1; font-size:.82rem; flex-shrink:0;">
                3
            </div>
            <div>
                <div
                    style="font-weight:700; font-size:.875rem;
                        color:#0f172a; margin-bottom:.15rem;">
                    Enable Two-Factor Auth
                </div>
                <div style="font-size:.78rem; color:#64748b;">
                    Keep your financial data secure
                </div>
            </div>
        </div>
    </div>

    <hr class="divider">
    <div style="text-align:center;">
        <a href="{{ url('/dashboard') }}" class="email-btn">
            Go to Dashboard →
        </a>
    </div>
@endsection
