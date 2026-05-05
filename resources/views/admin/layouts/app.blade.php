<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f1f5f9;
        }

        #admin-sidebar {
            width: 240px;
            min-height: 100vh;
            background: #1e1b4b;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .admin-brand {
            padding: 1.25rem 1.5rem;
            font-size: 1rem;
            font-weight: 800;
            color: #fff;
            border-bottom: 1px solid #312e81;
            letter-spacing: -0.02em;
        }

        .admin-brand span {
            color: #a5b4fc;
        }

        .admin-nav-section {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #4338ca;
            padding: 1rem 1.5rem 0.3rem;
            font-weight: 700;
        }

        .admin-nav-link {
            color: #a5b4fc;
            padding: 0.6rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.15s;
        }

        .admin-nav-link:hover,
        .admin-nav-link.active {
            background: #312e81;
            color: #fff;
            border-left-color: #818cf8;
        }

        #admin-topnav {
            margin-left: 240px;
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            height: 56px;
            position: sticky;
            top: 0;
            z-index: 999;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
        }

        #admin-content {
            margin-left: 240px;
            padding: 1.75rem 2rem;
        }

        .admin-stat-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 1.25rem 1.5rem;
            transition: transform 0.2s;
        }

        .admin-stat-card:hover {
            transform: translateY(-2px);
        }

        .admin-stat-card .label {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #64748b;
        }

        .admin-stat-card .value {
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: #0f172a;
        }

        .admin-badge {
            padding: 0.2rem 0.55rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            background: #ede9fe;
            color: #6d28d9;
        }
    </style>
    @stack('styles')
</head>

<body>

    {{-- Sidebar --}}
    <nav id="admin-sidebar">
        <div class="admin-brand">
            <i class="bi bi-shield-check me-2"></i>
            Money<span>Tracker</span> Admin
        </div>

        <div class="admin-nav-section">Overview</div>
        <a href="{{ route('admin.dashboard') }}"
            class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>

        <div class="admin-nav-section">Manage</div>
        <a href="{{ route('admin.users.index') }}"
            class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Users
            <span class="admin-badge ms-auto">{{ \App\Models\User::count() }}</span>
        </a>
        <a href="{{ route('admin.expenses.index') }}"
            class="admin-nav-link {{ request()->routeIs('admin.expenses.*') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i> All Expenses
        </a>

        <div class="admin-nav-section">Account</div>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="admin-nav-link btn btn-link w-100 text-start" style="color:#f87171;">
                <i class="bi bi-box-arrow-left"></i> Logout
            </button>
        </form>
    </nav>

    {{-- Top Navbar --}}
    <nav id="admin-topnav">
        <span style="font-weight:700; font-size:0.9rem; color:#0f172a;">
            @yield('title', 'Dashboard')
        </span>
        <div class="ms-auto d-flex align-items-center gap-3">
            <span class="badge bg-danger">Admin</span>
            <span style="font-size:0.85rem; color:#64748b;">
                {{ Auth::guard('admin')->user()->name }}
            </span>
        </div>
    </nav>

    {{-- Content --}}
    <main id="admin-content">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
