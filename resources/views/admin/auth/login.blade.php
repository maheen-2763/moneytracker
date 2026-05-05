<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — MoneyTracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #0f172a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .admin-login-card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 20px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
        }

        .admin-login-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #4338ca, #6366f1);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #fff;
            margin-bottom: 1.5rem;
        }

        .admin-login-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.03em;
            margin-bottom: 0.25rem;
        }

        .admin-login-sub {
            color: #64748b;
            font-size: 0.85rem;
            margin-bottom: 2rem;
        }

        .form-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
        }

        .form-control {
            background: #0f172a;
            border: 1.5px solid #334155;
            color: #e2e8f0;
            border-radius: 10px;
            padding: 0.7rem 1rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .form-control:focus {
            background: #0f172a;
            border-color: #6366f1;
            color: #e2e8f0;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .btn-admin-login {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(135deg, #4338ca, #6366f1);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: opacity 0.2s;
        }

        .btn-admin-login:hover {
            opacity: 0.9;
            color: #fff;
        }

        .back-link {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.78rem;
            color: #475569;
        }

        .back-link a {
            color: #6366f1;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="admin-login-card">
        <div class="admin-login-icon">
            <i class="bi bi-shield-check"></i>
        </div>
        <div class="admin-login-title">Admin Portal</div>
        <div class="admin-login-sub">MoneyTracker — Restricted Access</div>

        @if ($errors->any())
            <div class="alert alert-danger py-2 small">
                <i class="bi bi-exclamation-circle me-1"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                    placeholder="admin@moneytracker.com" autofocus required>
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-admin-login">
                <i class="bi bi-shield-lock me-2"></i>Sign in as Admin
            </button>
        </form>

        <div class="back-link">
            <a href="{{ route('login') }}">← Back to user login</a>
        </div>
    </div>

</body>

</html>
