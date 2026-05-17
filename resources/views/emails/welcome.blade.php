@extends('emails.layouts.base')

@section('content')
    <div class="email-title">Welcome, {{ $user->name }}! 👋</div>
    <div class="email-subtitle">
        Your MoneyTracker account is ready. Start taking control
        of your finances today — it's free!
    </div>

    <div class="alert-box success">
        <span class="alert-icon">✅</span>
        <div class="alert-text">
            <strong>Account Created Successfully</strong>
            You're all set! Your account is ready to use.
        </div>
    </div>

    {{-- Getting Started Steps --}}
    <div style="margin: 1.5rem 0;">

        <div class="step">
            <div class="step-num">1</div>
            <div>
                <div class="step-title">Add your first expense</div>
                <div class="step-desc">Track where your money goes by category — food, travel, health and more.</div>
            </div>
        </div>

        <div class="step">
            <div class="step-num">2</div>
            <div>
                <div class="step-title">Set monthly budgets</div>
                <div class="step-desc">Get alerts before you overspend so you always stay on track.</div>
            </div>
        </div>

        <div class="step">
            <div class="step-num">3</div>
            <div>
                <div class="step-title">Enable Two-Factor Auth</div>
                <div class="step-desc">Keep your financial data secure with Google Authenticator.</div>
            </div>
        </div>

        <div class="step">
            <div class="step-num">4</div>
            <div>
                <div class="step-title">Export your reports</div>
                <div class="step-desc">Download your expenses as PDF or Excel anytime.</div>
            </div>
        </div>

    </div>

    <hr class="divider">

    {{-- CTA --}}
    <div style="text-align: center;">
        <a href="{{ url('/dashboard') }}" class="email-btn">
            Go to Dashboard →
        </a>
    </div>

    <div style="text-align: center; margin-top: 16px;">
        <a href="{{ url('/profile/security') }}" class="email-btn-secondary">
            🔒 Enable 2FA
        </a>
    </div>
@endsection
