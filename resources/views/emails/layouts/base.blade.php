<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MoneyTracker</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f1f5f9;
            color: #0f172a;
            padding: 40px 16px;
        }

        .wrapper {
            max-width: 560px;
            margin: 0 auto;
        }

        /* Header */
        .email-header {
            text-align: center;
            padding: 24px 0 20px;
        }

        .email-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .email-brand-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .email-brand-text {
            font-size: 1.2rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.03em;
        }

        .email-brand-text span {
            color: #6366f1;
        }

        /* Card */
        .email-card {
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
        }

        /* Top accent bar */
        .email-accent {
            height: 4px;
            background: linear-gradient(90deg, #6366f1, #8b5cf6, #a78bfa);
        }

        /* Body */
        .email-body {
            padding: 36px 40px;
        }

        /* Title */
        .email-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
            margin-bottom: 8px;
        }

        .email-subtitle {
            font-size: 0.875rem;
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 24px;
        }

        /* Alert boxes */
        .alert-box {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .alert-box.success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
        }

        .alert-box.warning {
            background: #fffbeb;
            border: 1px solid #fde68a;
        }

        .alert-box.danger {
            background: #fef2f2;
            border: 1px solid #fecaca;
        }

        .alert-icon {
            font-size: 1.1rem;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .alert-text {
            font-size: 0.82rem;
            color: #374151;
            line-height: 1.6;
        }

        .alert-text strong {
            display: block;
            margin-bottom: 2px;
            font-size: 0.875rem;
        }

        /* Steps */
        .step {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .step-num {
            width: 28px;
            height: 28px;
            background: #eef2ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: #6366f1;
            font-size: 0.82rem;
            flex-shrink: 0;
        }

        .step-title {
            font-weight: 700;
            font-size: 0.875rem;
            color: #0f172a;
            margin-bottom: 2px;
        }

        .step-desc {
            font-size: 0.78rem;
            color: #64748b;
            line-height: 1.5;
        }

        /* Divider */
        .divider {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 24px 0;
        }

        /* Button */
        .email-btn {
            display: inline-block;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            letter-spacing: 0.01em;
            box-shadow: 0 4px 16px rgba(99, 102, 241, 0.3);
        }

        .email-btn-secondary {
            display: inline-block;
            background: #f8fafc;
            color: #6366f1 !important;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.875rem;
            border: 1.5px solid #e2e8f0;
        }

        /* Stats row */
        .stat-row {
            display: flex;
            gap: 12px;
            margin: 20px 0;
        }

        .stat-box {
            flex: 1;
            background: #f8fafc;
            border-radius: 12px;
            padding: 14px;
            text-align: center;
            border: 1px solid #e2e8f0;
        }

        .stat-value {
            font-size: 1.2rem;
            font-weight: 800;
            color: #0f172a;
        }

        .stat-label {
            font-size: 0.68rem;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-top: 4px;
        }

        /* Progress bar */
        .progress-wrap {
            background: #e2e8f0;
            border-radius: 99px;
            height: 8px;
            overflow: hidden;
            margin: 8px 0;
        }

        .progress-bar {
            height: 100%;
            border-radius: 99px;
        }

        /* Footer */
        .email-footer {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 20px 40px;
            text-align: center;
        }

        .email-footer p {
            font-size: 0.72rem;
            color: #94a3b8;
            line-height: 1.8;
        }

        .email-footer a {
            color: #6366f1;
            text-decoration: none;
        }

        /* Bottom note */
        .email-note {
            text-align: center;
            padding: 16px 0 0;
            font-size: 0.72rem;
            color: #94a3b8;
        }
    </style>
</head>

<body>
    <div class="wrapper">

        {{-- ── Brand Header ── --}}
        <div class="email-header">
            <a href="{{ url('/') }}" class="email-brand">
                <div class="email-brand-icon">📈</div>
                <span class="email-brand-text">
                    Money<span>Tracker</span>
                </span>
            </a>
        </div>

        {{-- ── Email Card ── --}}
        <div class="email-card">
            <div class="email-accent"></div>
            <div class="email-body">
                @yield('content')
            </div>

            {{-- ── Footer ── --}}
            <div class="email-footer">
                <p>
                    You're receiving this because you have an account at
                    <a href="{{ url('/') }}">MoneyTracker</a>.<br>
                    <a href="{{ url('/profile') }}">Manage preferences</a>
                    &nbsp;·&nbsp;
                    <a href="{{ url('/') }}">Visit MoneyTracker</a>
                </p>
            </div>
        </div>

        {{-- ── Bottom note ── --}}
        <div class="email-note">
            © {{ date('Y') }} MoneyTracker · Built with ❤️ by Mohammed Maheen Afzal
        </div>

    </div>
</body>

</html>
