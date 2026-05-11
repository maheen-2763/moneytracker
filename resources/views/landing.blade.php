<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoneyTracker — Your finances, finally under control.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700;800&family=Space+Mono:wght@400;700&display=swap"
        rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --accent: #6366f1;
            --accent-light: #a5b4fc;
            --bg: #050914;
            --card: rgba(30, 41, 59, 0.5);
            --border: rgba(255, 255, 255, 0.06);
            --text: #e2e8f0;
            --muted: #64748b;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Sora', sans-serif;
            background: var(--bg);
            color: var(--text);
            overflow-x: hidden;
        }

        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 99px;
        }

        /* ── Grid background ── */
        .grid-bg {
            background-image:
                linear-gradient(rgba(99, 102, 241, 0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99, 102, 241, 0.06) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        /* ── Shimmer text ── */
        .shimmer {
            background: linear-gradient(90deg, #6366f1, #a5b4fc, #818cf8, #6366f1);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 3s linear infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: 200% center;
            }

            100% {
                background-position: -200% center;
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-12px);
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateX(100%) scale(0.8);
            }

            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        /* ── Navbar ── */
        #navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s;
        }

        #navbar.scrolled {
            background: rgba(5, 9, 20, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(99, 102, 241, 0.15);
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
        }

        .nav-brand-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .nav-brand-text {
            font-weight: 800;
            font-size: 1rem;
            letter-spacing: -0.02em;
            color: #fff;
        }

        .nav-brand-text span {
            color: #818cf8;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.2s;
        }

        .nav-links a:hover {
            color: var(--accent-light);
        }

        .btn-nav {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 700;
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .btn-nav:hover {
            opacity: 0.9;
            color: #fff;
        }

        /* ── Hero ── */
        #hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 8rem 2rem 4rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-glow-1 {
            position: absolute;
            top: 15%;
            left: 10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-glow-2 {
            position: absolute;
            bottom: 10%;
            right: 5%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-badge {
            background: rgba(99, 102, 241, 0.15);
            border: 1px solid rgba(99, 102, 241, 0.3);
            color: #a5b4fc;
            padding: 0.35rem 1rem;
            border-radius: 99px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-family: 'Space Mono', monospace;
            margin-bottom: 1.5rem;
            animation: fadeUp 0.6s ease both;
            display: inline-block;
        }

        .hero-title {
            font-size: clamp(2.5rem, 6vw, 5rem);
            font-weight: 800;
            line-height: 1.05;
            letter-spacing: -0.04em;
            max-width: 860px;
            animation: fadeUp 0.7s 0.1s ease both;
        }

        .hero-sub {
            margin-top: 1.5rem;
            font-size: 1.05rem;
            color: var(--muted);
            max-width: 520px;
            line-height: 1.7;
            animation: fadeUp 0.7s 0.2s ease both;
        }

        .hero-btns {
            display: flex;
            gap: 1rem;
            margin-top: 2.5rem;
            flex-wrap: wrap;
            justify-content: center;
            animation: fadeUp 0.7s 0.3s ease both;
        }

        .btn-primary-hero {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            padding: 0.9rem 2rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.95rem;
            text-decoration: none;
            box-shadow: 0 8px 32px rgba(99, 102, 241, 0.35);
            transition: transform 0.2s, box-shadow 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(99, 102, 241, 0.5);
            color: #fff;
        }

        .btn-ghost {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text);
            padding: 0.9rem 2rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.95rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: background 0.2s;
        }

        .btn-ghost:hover {
            background: rgba(255, 255, 255, 0.08);
            color: var(--text);
        }

        /* Stats */
        .hero-stats {
            display: flex;
            gap: 3rem;
            margin-top: 4rem;
            flex-wrap: wrap;
            justify-content: center;
            animation: fadeUp 0.7s 0.4s ease both;
        }

        .hero-stat-num {
            font-size: 2rem;
            font-weight: 800;
            color: #a5b4fc;
            letter-spacing: -0.03em;
            font-family: 'Space Mono', monospace;
        }

        .hero-stat-label {
            font-size: 0.68rem;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-top: 0.2rem;
        }

        /* Dashboard preview */
        .dashboard-preview {
            margin-top: 4rem;
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 20px;
            padding: 1.5rem;
            max-width: 700px;
            width: 100%;
            backdrop-filter: blur(20px);
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.4);
            animation: float 6s ease-in-out infinite;
        }

        .browser-bar {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
        }

        .browser-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .browser-url {
            flex: 1;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 6px;
            height: 22px;
            display: flex;
            align-items: center;
            padding-left: 0.75rem;
            font-size: 0.68rem;
            color: #475569;
            font-family: 'Space Mono', monospace;
        }

        .mini-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .mini-stat-card {
            background: rgba(255, 255, 255, 0.04);
            border-radius: 10px;
            padding: 0.75rem;
        }

        .mini-stat-label {
            font-size: 0.58rem;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .mini-stat-val {
            font-size: 0.9rem;
            font-weight: 800;
            margin-top: 0.2rem;
            font-family: 'Space Mono', monospace;
        }

        .mini-chart {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 10px;
            padding: 1rem;
        }

        .mini-chart-label {
            font-size: 0.65rem;
            color: #475569;
            margin-bottom: 0.75rem;
        }

        .chart-bars {
            display: flex;
            align-items: flex-end;
            gap: 4px;
            height: 50px;
        }

        .chart-bar {
            flex: 1;
            border-radius: 3px 3px 0 0;
            background: rgba(99, 102, 241, 0.2);
            transition: height 0.5s;
        }

        .chart-bar.active {
            background: linear-gradient(180deg, #6366f1, #8b5cf6);
        }

        /* ── Section shared ── */
        section {
            padding: 6rem 2rem;
        }

        .section-label {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--accent);
            font-family: 'Space Mono', monospace;
            margin-bottom: 0.75rem;
        }

        .section-title {
            font-size: clamp(1.8rem, 4vw, 3rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1.1;
        }

        .section-center {
            text-align: center;
            margin-bottom: 3.5rem;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
        }

        /* Animate on scroll */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ── Features ── */
        #features {
            background: transparent;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1rem;
        }

        .feature-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .feature-card:hover,
        .feature-card.active {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(139, 92, 246, 0.1));
            border-color: rgba(99, 102, 241, 0.4);
            transform: translateY(-4px);
        }

        .feature-emoji {
            font-size: 1.75rem;
            margin-bottom: 0.75rem;
        }

        .feature-title {
            font-weight: 700;
            font-size: 0.95rem;
            margin-bottom: 0.4rem;
            color: var(--text);
        }

        .feature-card.active .feature-title {
            color: #a5b4fc;
        }

        .feature-desc {
            font-size: 0.78rem;
            color: var(--muted);
            line-height: 1.6;
        }

        /* ── Stack ── */
        #stack {
            background: rgba(15, 23, 42, 0.6);
        }

        .stack-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            justify-content: center;
            margin-bottom: 3rem;
        }

        .stack-pill {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            padding: 0.6rem 1.25rem;
            font-size: 0.85rem;
            font-weight: 600;
            font-family: 'Space Mono', monospace;
            transition: all 0.2s;
            cursor: default;
        }

        .stack-pill:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .code-block {
            background: #020617;
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 16px;
            padding: 1.5rem;
            font-family: 'Space Mono', monospace;
            font-size: 0.78rem;
            line-height: 1.8;
            max-width: 600px;
            margin: 0 auto;
        }

        .code-dot-bar {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
            align-items: center;
        }

        .code-filename {
            font-size: 0.68rem;
            color: #334155;
            margin-left: 0.5rem;
        }

        .c-purple {
            color: #818cf8;
        }

        .c-blue {
            color: #a5b4fc;
        }

        .c-yellow {
            color: #fbbf24;
        }

        .c-green {
            color: #86efac;
        }

        .c-gray {
            color: #334155;
        }

        .c-white {
            color: #e2e8f0;
        }

        /* ── API ── */
        #api {
            background: transparent;
        }

        .api-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .api-route {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.55rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .method-badge {
            padding: 0.15rem 0.55rem;
            border-radius: 4px;
            font-size: 0.65rem;
            font-weight: 800;
            font-family: 'Space Mono', monospace;
            min-width: 50px;
            text-align: center;
        }

        .method-get {
            background: #14532d30;
            color: #4ade80;
        }

        .method-post {
            background: #1e3a5f30;
            color: #60a5fa;
        }

        .method-put {
            background: #71320030;
            color: #fbbf24;
        }

        .method-delete {
            background: #7f1d1d30;
            color: #f87171;
        }

        .route-path {
            font-size: 0.8rem;
            color: #94a3b8;
            font-family: 'Space Mono', monospace;
        }

        /* ── Tests ── */
        #tests {
            background: rgba(15, 23, 42, 0.6);
        }

        .test-terminal {
            background: #020617;
            border: 1px solid rgba(34, 197, 94, 0.2);
            border-radius: 16px;
            padding: 2rem;
            font-family: 'Space Mono', monospace;
            font-size: 0.78rem;
            max-width: 700px;
            margin: 0 auto;
        }

        .test-row {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        }

        .test-suite {
            color: #475569;
            flex: 1;
        }

        .test-count {
            color: #22c55e;
            font-size: 0.7rem;
        }

        .test-summary {
            margin-top: 1.25rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(34, 197, 94, 0.2);
            color: #22c55e;
            font-weight: 700;
        }

        /* ── CTA ── */
        #cta {
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-glow {
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at center, rgba(99, 102, 241, 0.12) 0%, transparent 70%);
            pointer-events: none;
        }

        /* ── Footer ── */
        footer {
            padding: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            text-align: center;
            font-size: 0.8rem;
            color: #334155;
        }

        footer span {
            color: var(--accent);
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            #navbar .nav-links {
                display: none;
            }

            .api-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .mini-stats {
                grid-template-columns: 1fr 1fr;
            }

            .hero-stats {
                gap: 1.5rem;
            }

            section {
                padding: 4rem 1.25rem;
            }
        }
    </style>
</head>

<body>

    {{-- ── NAVBAR ── --}}
    <nav id="navbar">
        <a href="/" class="nav-brand">
            <div class="nav-brand-icon">💰</div>
            <span class="nav-brand-text">Money<span>Tracker</span></span>
        </a>

        <ul class="nav-links">
            <li><a href="#features">Features</a></li>
            <li><a href="#stack">Stack</a></li>
            <li><a href="#api">API</a></li>
            <li><a href="#tests">Tests</a></li>
        </ul>

        <div class="d-flex gap-2 align-items-center">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-nav">Dashboard →</a>
            @else
                <a href="{{ route('login') }}"
                    style="color:#94a3b8; text-decoration:none; font-size:.85rem; margin-right:.75rem;">Login</a>
                <a href="{{ route('register') }}" class="btn-nav">Get Started →</a>
            @endauth
        </div>
    </nav>

    {{-- ── HERO ── --}}
    <section id="hero" class="grid-bg">
        <div class="hero-glow-1"></div>
        <div class="hero-glow-2"></div>

        <span class="hero-badge">✦ Laravel 11 · Full-Stack · Open Source</span>

        <h1 class="hero-title">
            Your finances,<br>
            <span class="shimmer">finally under control.</span>
        </h1>

        <p class="hero-sub">
            MoneyTracker is a production-grade personal finance app built with Laravel 11.
            Track expenses, set budgets, get alerts — all in one beautiful dashboard.
        </p>

        <div class="hero-btns">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-primary-hero">
                    🚀 Go to Dashboard
                </a>
            @else
                <a href="{{ route('register') }}" class="btn-primary-hero">
                    🚀 Get Started Free
                </a>
                <a href="{{ route('login') }}" class="btn-ghost">
                    Sign In →
                </a>
            @endauth
            <a href="https://github.com/maheen-2763/moneytracker" target="_blank" class="btn-ghost">
                ⭐ GitHub
            </a>
        </div>

        {{-- Stats --}}
        <div class="hero-stats">
            @foreach ([['57', 'Tests Passing'], ['117', 'Assertions'], ['15+', 'Features'], ['100%', 'Auth Secure']] as $s)
                <div style="text-align:center;">
                    <div class="hero-stat-num">{{ $s[0] }}</div>
                    <div class="hero-stat-label">{{ $s[1] }}</div>
                </div>
            @endforeach
        </div>

        {{-- Dashboard Preview --}}
        <div class="dashboard-preview reveal" style="margin-top:4rem;">
            <div class="browser-bar">
                <div class="browser-dot" style="background:#ef4444;"></div>
                <div class="browser-dot" style="background:#f59e0b;"></div>
                <div class="browser-dot" style="background:#22c55e;"></div>
                <div class="browser-url">moneytracker.app/dashboard</div>
            </div>

            <div class="mini-stats">
                @foreach ([['Total Spent', '₹25,430', '#ef4444'], ['This Month', '₹4,200', '#6366f1'], ['This Week', '₹850', '#22c55e'], ['Expenses', '47', '#f59e0b']] as $c)
                    <div class="mini-stat-card">
                        <div class="mini-stat-label">{{ $c[0] }}</div>
                        <div class="mini-stat-val" style="color:{{ $c[2] }}">{{ $c[1] }}</div>
                    </div>
                @endforeach
            </div>

            <div class="mini-chart">
                <div class="mini-chart-label">Monthly Spending Trend</div>
                <div class="chart-bars">
                    @foreach ([30, 55, 40, 70, 45, 85, 60, 90, 50, 75, 65, 100] as $i => $h)
                        <div class="chart-bar {{ $i === 11 ? 'active' : '' }}" style="height:{{ $h }}%">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ── FEATURES ── --}}
    <section id="features">
        <div class="container">
            <div class="section-center reveal">
                <div class="section-label">Features</div>
                <h2 class="section-title">
                    Everything you need to<br>
                    <span class="shimmer">manage your money.</span>
                </h2>
            </div>

            <div class="features-grid">
                @foreach ([['💸', 'Expense Tracking', 'Log every rupee with categories, notes, and receipts. Full CRUD with soft delete.'], ['📊', 'Smart Dashboard', 'Live Chart.js charts showing monthly trends, category breakdowns, and weekly summaries.'], ['🏷️', 'Budget Limits', 'Set monthly limits per category. Get visual warnings before you overspend.'], ['🔔', 'Smart Alerts', 'Bell notifications + email alerts the moment you exceed a budget.'], ['📈', 'Reports & Export', 'Filter by date and category. Export to PDF or Excel in one click.'], ['🔒', '2FA Security', 'Google Authenticator support keeps your financial data locked tight.'], ['🛡️', 'Admin Panel', 'Separate admin guard with full user management, stats, and audit views.'], ['🌐', 'REST API', 'Sanctum-authenticated API with interactive docs at /api/docs.']] as $f)
                    <div class="feature-card reveal" onclick="this.classList.toggle('active')">
                        <div class="feature-emoji">{{ $f[0] }}</div>
                        <div class="feature-title">{{ $f[1] }}</div>
                        <div class="feature-desc">{{ $f[2] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── STACK ── --}}
    <section id="stack">
        <div class="container">
            <div class="section-center reveal">
                <div class="section-label">Tech Stack</div>
                <h2 class="section-title">
                    Built with the <span class="shimmer">right tools.</span>
                </h2>
            </div>

            <div class="stack-pills reveal">
                @foreach ([['Laravel 11', '#FF2D20'], ['PHP 8.2', '#777BB4'], ['MySQL', '#00758F'], ['Bootstrap 5', '#7952B3'], ['Chart.js', '#FF6384'], ['PestPHP', '#22c55e'], ['Sanctum', '#f59e0b'], ['DomPDF', '#6366f1']] as $s)
                    <div class="stack-pill" style="color:{{ $s[1] }}">{{ $s[0] }}</div>
                @endforeach
            </div>

            <div class="code-block reveal">
                <div class="code-dot-bar">
                    <div class="browser-dot" style="width:8px; height:8px; background:#ef4444;"></div>
                    <div class="browser-dot" style="width:8px; height:8px; background:#f59e0b;"></div>
                    <div class="browser-dot" style="width:8px; height:8px; background:#22c55e;"></div>
                    <span class="code-filename">ExpenseController.php</span>
                </div>
                <div><span class="c-purple">public function</span> <span class="c-blue">store</span><span
                        class="c-white">(StoreExpenseRequest </span><span class="c-yellow">$request</span><span
                        class="c-white">)</span></div>
                <div><span class="c-white">{</span></div>
                <div style="padding-left:1.5rem;"><span class="c-gray">// Validated, authorized, service layer</span>
                </div>
                <div style="padding-left:1.5rem;"><span class="c-yellow">$expense</span> <span class="c-white">=
                    </span><span class="c-green">$this</span><span class="c-white">->service->create(...);</span>
                </div>
                <div style="padding-left:1.5rem;"><span class="c-green">$this</span><span
                        class="c-white">->checkBudget(</span><span class="c-yellow">$data</span><span
                        class="c-white">['category']);</span></div>
                <div style="padding-left:1.5rem;"><span class="c-purple">return</span> <span
                        class="c-white">redirect()->route(</span><span class="c-green">'expenses.index'</span><span
                        class="c-white">);</span></div>
                <div><span class="c-white">}</span></div>
            </div>
        </div>
    </section>

    {{-- ── API ── --}}
    <section id="api">
        <div class="container">
            <div class="api-grid reveal">
                <div>
                    <div class="section-label">REST API</div>
                    <h2 class="section-title" style="font-size:clamp(1.8rem,4vw,2.5rem); margin: .75rem 0 1rem;">
                        Full API with<br><span class="shimmer">interactive docs.</span>
                    </h2>
                    <p style="color:var(--muted); line-height:1.7; font-size:.9rem; margin-bottom:1.5rem;">
                        Every feature exposed via a clean REST API. Token-based auth with Laravel Sanctum.
                        Interactive documentation at
                        <a href="{{ route('api.docs') }}"
                            style="color:#a5b4fc; font-family:'Space Mono',monospace;">/api/docs</a>.
                    </p>

                    @foreach ([['GET', '/api/v1/expenses', 'method-get'], ['POST', '/api/v1/expenses', 'method-post'], ['GET', '/api/v1/budgets', 'method-get'], ['GET', '/api/v1/dashboard', 'method-get'], ['POST', '/api/v1/login', 'method-post'], ['DELETE', '/api/v1/expenses/{id}', 'method-delete']] as $r)
                        <div class="api-route">
                            <span class="method-badge {{ $r[2] }}">{{ $r[0] }}</span>
                            <span class="route-path">{{ $r[1] }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="code-block">
                    <div class="c-gray" style="margin-bottom:.5rem;">// GET /api/v1/dashboard</div>
                    <div><span class="c-white">{</span></div>
                    <div style="padding-left:1.5rem;"><span class="c-blue">"summary"</span><span class="c-white">:
                            {</span></div>
                    <div style="padding-left:3rem;"><span class="c-blue">"total_all_time"</span><span
                            class="c-white">: </span><span class="c-yellow">25430.50</span><span
                            class="c-white">,</span></div>
                    <div style="padding-left:3rem;"><span class="c-blue">"this_month"</span><span class="c-white">:
                        </span><span class="c-yellow">4200.00</span><span class="c-white">,</span></div>
                    <div style="padding-left:3rem;"><span class="c-blue">"total_expenses"</span><span
                            class="c-white">: </span><span class="c-yellow">47</span></div>
                    <div style="padding-left:1.5rem;"><span class="c-white">},</span></div>
                    <div style="padding-left:1.5rem;"><span class="c-blue">"by_category"</span><span
                            class="c-white">: [...],</span></div>
                    <div style="padding-left:1.5rem;"><span class="c-blue">"by_month"</span><span class="c-white">:
                            [...]</span></div>
                    <div><span class="c-white">}</span></div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── TESTS ── --}}
    <section id="tests">
        <div class="container">
            <div class="section-center reveal">
                <div class="section-label" style="color:#22c55e;">Testing</div>
                <h2 class="section-title">
                    <span style="color:#22c55e;">57 tests.</span> All passing.
                </h2>
            </div>

            <div class="test-terminal reveal">
                @foreach ([['Tests\\Feature\\ProfileTest', 16], ['Tests\\Feature\\BudgetTest', 6], ['Tests\\Feature\\ExpenseTest', 7], ['Tests\\Feature\\NotificationTest', 3], ['Tests\\Feature\\Auth', 19], ['Tests\\Unit\\BudgetTest', 5]] as $t)
                    <div class="test-row">
                        <span style="color:#22c55e;">✓</span>
                        <span class="test-suite">{{ $t[0] }}</span>
                        <span class="test-count">{{ $t[1] }} tests</span>
                    </div>
                @endforeach

                <div class="test-summary">
                    Tests: <span style="color:#fff;">57 passed</span>
                    · Assertions: <span style="color:#fff;">117</span>
                    · Duration: <span style="color:#fff;">5.68s</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ── CTA ── --}}
    <section id="cta">
        <div class="cta-glow"></div>
        <div class="container reveal" style="position:relative;">
            <div
                style="font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.12em; color:#6366f1; font-family:'Space Mono',monospace; margin-bottom:1rem;">
                Open Source · Portfolio Project
            </div>
            <h2 class="section-title" style="margin-bottom:1.5rem;">Ready to explore?</h2>
            <p style="color:var(--muted); font-size:1rem; max-width:480px; margin:0 auto 2.5rem; line-height:1.7;">
                Built with clean architecture, tested thoroughly, and documented professionally.
                A real-world Laravel app ready for production.
            </p>
            <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-primary-hero">🚀 Go to Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary-hero">🚀 Get Started Free</a>
                    <a href="{{ route('login') }}" class="btn-ghost">Sign In</a>
                @endauth
            </div>
        </div>
    </section>

    {{-- ── FOOTER ── --}}
    <footer>
        Built with ❤️ by
        <span>Mohammed Maheen Afzal</span>
        · Laravel 11 · MIT License
        · <a href="{{ route('api.docs') }}" style="color:#6366f1; text-decoration:none;">API Docs</a>
    </footer>

    <script>
        // ── Scroll reveal ─────────────────────
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // ── Navbar scroll ─────────────────────
        window.addEventListener('scroll', () => {
            document.getElementById('navbar').classList
                .toggle('scrolled', window.scrollY > 40);
        });

        // ── Feature cards auto-rotate ─────────
        const cards = document.querySelectorAll('.feature-card');
        let current = 0;
        setInterval(() => {
            cards.forEach(c => c.classList.remove('active'));
            cards[current].classList.add('active');
            current = (current + 1) % cards.length;
        }, 2500);
    </script>

</body>

</html>
