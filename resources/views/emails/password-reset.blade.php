@extends('emails.layouts.base')

@section('content')
    {{-- Title --}}
    <div class="email-title">Reset Your Password 🔑</div>
    <div class="email-subtitle">
        Hi <strong style="color:#0f172a;">{{ $user->name }}</strong>,
        we received a request to reset your MoneyTracker password.
    </div>

    {{-- Info Alert --}}
    <div class="alert-box" style="background:#eef2ff; border:1px solid #c7d2fe;">
        <span class="alert-icon">🔐</span>
        <div class="alert-text" style="color:#3730a3;">
            <strong>Password Reset Requested</strong>
            Click the button below to choose a new password.
            This link expires in <strong>60 minutes</strong>.
        </div>
    </div>

    {{-- CTA --}}
    <div style="text-align:center; margin:28px 0;">
        <a href="{{ $resetUrl }}" class="email-btn">
            Reset Password →
        </a>
    </div>

    {{-- Security Note --}}
    <div class="alert-box warning">
        <span class="alert-icon">⚠️</span>
        <div class="alert-text">
            <strong>Didn't request this?</strong>
            If you didn't request a password reset, no action is needed.
            Your password will remain unchanged.
        </div>
    </div>

    <hr class="divider">

    {{-- Fallback URL --}}
    <div style="text-align:center;">
        <p style="font-size:0.75rem; color:#94a3b8; margin-bottom:8px;">
            If the button doesn't work, copy and paste this link:
        </p>
        <p
            style="font-size:0.72rem; color:#6366f1;
              font-family:'Courier New', monospace;
              word-break:break-all;">
            {{ $resetUrl }}
        </p>
    </div>
@endsection
