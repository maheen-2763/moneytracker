<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont,
                'Segoe UI', sans-serif;
            background: #f1f5f9;
            color: #1e293b;
            padding: 2rem 1rem;
        }

        .email-wrapper {
            max-width: 560px;
            margin: 0 auto;
        }

        /* Header */
        .email-header {
            background: linear-gradient(135deg, #4338ca, #6366f1);
            border-radius: 16px 16px 0 0;
            padding: 2rem;
            text-align: center;
        }

        .email-brand {
            font-size: 1.2rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.02em;
        }

        .email-brand span {
            color: #a5b4fc;
        }

        /* Body */
        .email-body {
            background: #fff;
            padding: 2rem;
        }

        .email-title {
            font-size: 1.3rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
        }

        .email-subtitle {
            color: #64748b;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        /* Stats card */
        .stat-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .stat-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
        }

        .stat-box .label {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #94a3b8;
            margin-bottom: 0.35rem;
        }

        .stat-box .value {
            font-size: 1.3rem;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        /* Alert box */
        .alert-box {
            border-radius: 10px;
            padding: 1rem 1.25rem;
            margin: 1.25rem 0;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .alert-box.danger {
            background: #fef2f2;
            border: 1px solid #fecaca;
        }

        .alert-box.warning {
            background: #fffbeb;
            border: 1px solid #fde68a;
        }

        .alert-box.success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
        }

        .alert-icon {
            font-size: 1.25rem;
        }

        .alert-text {
            font-size: 0.85rem;
            line-height: 1.5;
        }

        .alert-text strong {
            display: block;
            margin-bottom: 0.2rem;
        }

        /* CTA Button */
        .email-btn {
            display: inline-block;
            background: #6366f1;
            color: #fff !important;
            text-decoration: none;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.875rem;
            margin-top: 1.25rem;
        }

        .email-btn:hover {
            background: #4f46e5;
        }

        /* Expense table */
        .expense-table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
            font-size: 0.82rem;
        }

        .expense-table th {
            background: #f8fafc;
            padding: 0.6rem 0.75rem;
            text-align: left;
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #94a3b8;
            border-bottom: 1px solid #e2e8f0;
        }

        .expense-table td {
            padding: 0.65rem 0.75rem;
            border-bottom: 1px solid #f1f5f9;
            color: #475569;
        }

        .expense-table .amount {
            font-weight: 700;
            color: #ef4444;
        }

        /* Progress bar */
        .progress-wrap {
            background: #f1f5f9;
            border-radius: 99px;
            height: 8px;
            overflow: hidden;
            margin: 0.4rem 0;
        }

        .progress-bar {
            height: 100%;
            border-radius: 99px;
        }

        /* Divider */
        .divider {
            border: none;
            border-top: 1px solid #f1f5f9;
            margin: 1.5rem 0;
        }

        /* Footer */
        .email-footer {
            background: #f8fafc;
            border-radius: 0 0 16px 16px;
            padding: 1.25rem 2rem;
            text-align: center;
        }

        .email-footer p {
            font-size: 0.72rem;
            color: #94a3b8;
            line-height: 1.6;
        }

        .email-footer a {
            color: #6366f1;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="email-wrapper">

        {{-- Header --}}
        <div class="email-header">
            <div class="email-brand">
                💰 Money<span>Tracker</span>
            </div>
        </div>

        {{-- Body --}}
        <div class="email-body">
            @yield('content')
        </div>

        {{-- Footer --}}
        <div class="email-footer">
            <p>
                You're receiving this because you have an account at
                <a href="{{ url('/') }}">MoneyTracker</a>.<br>
                <a href="{{ url('/profile') }}">Manage email preferences</a>
                &nbsp;·&nbsp;
                <a href="{{ url('/') }}">Visit MoneyTracker</a>
            </p>
        </div>

    </div>
</body>

</html>
