<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoneyTracker — Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #0f172a;
            min-height: 100vh;
            display: flex;
        }

        /* ── Left Panel ── */
        .auth-left {
            width: 45%;
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .auth-left::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            top: -100px;
            left: -100px;
        }

        .auth-left::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -80px;
            right: -80px;
        }

        .auth-brand {
            font-size: 1.75rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.03em;
            margin-bottom: 0.5rem;
            z-index: 1;
        }

        .auth-brand span {
            color: #a5b4fc;
        }

        .auth-tagline {
            color: #c7d2fe;
            font-size: 0.9rem;
            margin-bottom: 3rem;
            z-index: 1;
        }

        .auth-features {
            list-style: none;
            z-index: 1;
            width: 100%;
            max-width: 280px;
        }

        .auth-features li {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #e0e7ff;
            font-size: 0.875rem;
            padding: 0.6rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .auth-features li:last-child {
            border: none;
        }

        .auth-features li i {
            width: 28px;
            height: 28px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            flex-shrink: 0;
        }

        /* ── Right Panel ── */
        .auth-right {
            flex: 1;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .auth-card {
            width: 100%;
            max-width: 400px;
        }

        .auth-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.03em;
            margin-bottom: 0.35rem;
        }

        .auth-subtitle {
            color: #64748b;
            font-size: 0.875rem;
            margin-bottom: 2rem;
        }

        /* ── Form ── */
        .form-label {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #475569;
            margin-bottom: 0.4rem;
        }

        .form-control {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.7rem 1rem;
            font-size: 0.9rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #0f172a;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
            outline: none;
        }

        .input-icon-wrap {
            position: relative;
        }

        .input-icon-wrap i {
            position: absolute;
            left: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.9rem;
        }

        .input-icon-wrap .form-control {
            padding-left: 2.5rem;
        }

        /* ── Password toggle ── */
        .pass-wrap {
            position: relative;
        }

        .pass-toggle {
            position: absolute;
            right: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 0;
            font-size: 0.9rem;
        }

        .pass-toggle:hover {
            color: #6366f1;
        }

        /* ── Submit button ── */
        .btn-auth {
            width: 100%;
            padding: 0.75rem;
            background: #6366f1;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s;
            letter-spacing: 0.01em;
        }

        .btn-auth:hover {
            background: #4f46e5;
            transform: translateY(-1px);
        }

        .btn-auth:active {
            transform: translateY(0);
        }

        /* ── Divider ── */
        .auth-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
            color: #94a3b8;
            font-size: 0.78rem;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        /* ── Footer link ── */
        .auth-footer {
            text-align: center;
            font-size: 0.82rem;
            color: #64748b;
            margin-top: 1.5rem;
        }

        .auth-footer a {
            color: #6366f1;
            font-weight: 700;
            text-decoration: none;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        /* ── Error ── */
        .invalid-feedback {
            font-size: 0.78rem;
        }

        .form-control.is-invalid {
            border-color: #ef4444;
        }

        .auth-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.82rem;
            color: #dc2626;
            margin-bottom: 1.25rem;
        }

        /* ── Mobile ── */
        @media (max-width: 768px) {
            .auth-left {
                display: none;
            }

            .auth-right {
                background: #f1f5f9;
            }

            .auth-card {
                background: #fff;
                border-radius: 16px;
                padding: 2rem;
                box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            }
        }
    </style>
</head>

<body>

    <div class="auth-left">
        <div class="auth-brand">
            <i class="bi bi-wallet2 me-2"></i>Money<span>Tracker</span>
        </div>
        <p class="auth-tagline">Your personal finance companion</p>

        <ul class="auth-features">
            <li>
                <i class="bi bi-bar-chart-line"></i>
                Track expenses by category
            </li>
            <li>
                <i class="bi bi-piggy-bank"></i>
                Set monthly budget limits
            </li>
            <li>
                <i class="bi bi-bell"></i>
                Get budget exceeded alerts
            </li>
            <li>
                <i class="bi bi-file-earmark-arrow-down"></i>
                Export to PDF & Excel
            </li>
            <li>
                <i class="bi bi-phone"></i>
                Works on all devices
            </li>
        </ul>
    </div>

    <div class="auth-right">
        <div class="auth-card">

            <div class="auth-title">Welcome back 👋</div>
            <div class="auth-subtitle">Sign in to your MoneyTracker account</div>

            {{-- Errors --}}
            @if ($errors->any())
                <div class="auth-error">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('status'))
                <div class="auth-error" style="background:#f0fdf4; border-color:#bbf7d0; color:#16a34a;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-envelope"></i>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" placeholder="you@example.com" autofocus required>
                    </div>
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="form-label mb-0">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                style="font-size:0.75rem; color:#6366f1; text-decoration:none; font-weight:600">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    <div class="pass-wrap mt-1">
                        <div class="input-icon-wrap">
                            <i class="bi bi-lock"></i>
                            <input type="password" name="password" id="passwordInput"
                                class="form-control @error('password') is-invalid @enderror" placeholder="••••••••"
                                required>
                        </div>
                        <button type="button" class="pass-toggle" onclick="togglePassword()">
                            <i class="bi bi-eye" id="passIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Remember me --}}
                <div class="d-flex align-items-center gap-2 mb-4">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input m-0"
                        style="border-radius:5px;">
                    <label for="remember" style="font-size:0.82rem; color:#475569; cursor:pointer;">
                        Keep me signed in
                    </label>
                </div>

                <button type="submit" class="btn-auth">
                    Sign In →
                </button>

            </form>

            <div class="auth-footer">
                Don't have an account?
                <a href="{{ route('register') }}">Create one for free</a>
            </div>

            <div class="auth-footer">
                <a href="{{ route('admin.login.post') }}"> Login as Admin</a>
            </div>

        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon = document.getElementById('passIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }
    </script>
</body>

</html>
