<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- SEO Meta Tags --}}
    <meta name="description"
        content="MoneyTracker — Track expenses, set budgets, and get alerts. A production-grade personal finance app built with Laravel 11.">
    <meta name="keywords" content="money tracker, expense tracker, budget, personal finance, Laravel">
    <meta name="author" content="Mohammed Maheen Afzal">
    <meta name="robots" content="index, follow">

    {{-- Open Graph (for social sharing) --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="MoneyTracker — Your finances, finally under control.">
    <meta property="og:description" content="Track expenses, set budgets, get alerts — all in one beautiful dashboard.">
    <meta property="og:url" content="{{ url()->current() }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="MoneyTracker">
    <meta name="twitter:description" content="Track expenses, set budgets, get alerts.">

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'><x-app-logo/></text></svg>">

    {{-- Theme color (mobile browser bar) --}}
    <meta name="theme-color" content="#6366f1">
    <title>MoneyTracker — Your finances, finally under control.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700;800&family=Space+Mono:wght@400;700&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Sora', sans-serif;
        }

        .font-mono-space {
            font-family: 'Space Mono', monospace;
        }

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

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-fade-up {
            animation: fadeUp 0.7s ease both;
        }

        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: #050914;
        }

        ::-webkit-scrollbar-thumb {
            background: #6366f1;
            border-radius: 99px;
        }
    </style>
</head>

<body class="bg-[#050914] text-slate-200 overflow-x-hidden scroll-smooth">

    {{-- Background grid --}}
    <div
        class="fixed inset-0 bg-[linear-gradient(rgba(99,102,241,0.06)_1px,transparent_1px),linear-gradient(90deg,rgba(99,102,241,0.06)_1px,transparent_1px)] bg-[size:48px_48px] pointer-events-none z-0">
    </div>

    {{-- ── NAVBAR ── --}}
    <nav id="navbar"
        class="fixed top-0 left-0 right-0 z-50 px-8 py-4
                flex items-center justify-between
                transition-all duration-300">

        <x-app-logo size="md" :dark="true" />

        <ul class="hidden md:flex items-center gap-8 list-none">
            @foreach (['features' => 'Features', 'stack' => 'Stack', 'api' => 'API', 'tests' => 'Tests'] as $id => $label)
                <li>
                    <a href="#{{ $id }}"
                        class="text-slate-400 hover:text-indigo-300 text-sm no-underline transition">
                        {{ $label }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}"
                    class="px-5 py-2 rounded-lg text-sm font-bold text-white no-underline
                          bg-gradient-to-r from-indigo-500 to-violet-500
                          hover:opacity-90 transition">
                    Dashboard →
                </a>
            @else
                <a href="{{ route('login') }}" class="text-slate-400 hover:text-indigo-300 text-sm no-underline transition">
                    Login
                </a>
                <a href="{{ route('register') }}"
                    class="px-5 py-2 rounded-lg text-sm font-bold text-white no-underline
                          bg-gradient-to-r from-indigo-500 to-violet-500
                          hover:opacity-90 transition">
                    Get Started →
                </a>
            @endauth
        </div>
    </nav>

    {{-- ── HERO ── --}}
    <section id="hero"
        class="relative min-h-screen flex flex-col items-center justify-center
                    px-6 pt-32 pb-16 text-center z-10">

        {{-- Glows --}}
        <div
            class="absolute top-1/4 left-1/4 w-96 h-96 rounded-full
                    bg-indigo-500/10 blur-3xl pointer-events-none">
        </div>
        <div
            class="absolute bottom-1/4 right-1/4 w-[500px] h-[500px] rounded-full
                    bg-violet-500/10 blur-3xl pointer-events-none">
        </div>

        {{-- Badge --}}
        <span
            class="inline-block px-4 py-1.5 mb-6 rounded-full
                     bg-indigo-500/15 border border-indigo-500/30
                     text-indigo-300 text-xs font-bold uppercase tracking-widest
                     font-mono-space animate-fade-up">
            ✦ Laravel 11 · Full-Stack · Open Source
        </span>

        {{-- Title --}}
        <h1 class="text-5xl md:text-7xl font-extrabold leading-tight
                   tracking-tight max-w-4xl animate-fade-up"
            style="animation-delay:0.1s">
            Your finances,<br>
            <span class="shimmer">finally under control.</span>
        </h1>

        {{-- Subtitle --}}
        <p class="mt-6 text-base text-slate-500 max-w-lg leading-relaxed animate-fade-up" style="animation-delay:0.2s">
            MoneyTracker is a production-grade personal finance app built with Laravel 11.
            Track expenses, set budgets, get alerts — all in one beautiful dashboard.
        </p>

        {{-- Buttons --}}
        <div class="flex flex-wrap items-center justify-center gap-4 mt-10 animate-fade-up"
            style="animation-delay:0.3s">
            @auth
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center gap-2 px-8 py-3.5 rounded-xl
                          font-bold text-white no-underline
                          bg-gradient-to-r from-indigo-500 to-violet-500
                          shadow-xl shadow-indigo-500/30
                          hover:-translate-y-0.5 transition-all duration-200">
                    🚀 Go to Dashboard
                </a>
            @else
                <a href="{{ route('register') }}"
                    class="inline-flex items-center gap-2 px-8 py-3.5 rounded-xl
                          font-bold text-white no-underline
                          bg-gradient-to-r from-indigo-500 to-violet-500
                          shadow-xl shadow-indigo-500/30
                          hover:-translate-y-0.5 transition-all duration-200">
                    🚀 Get Started Free
                </a>
                <a href="{{ route('login') }}"
                    class="inline-flex items-center gap-2 px-8 py-3.5 rounded-xl
                          font-bold text-slate-200 no-underline
                          bg-white/5 border border-white/10
                          hover:bg-white/10 transition">
                    Sign In →
                </a>
            @endauth
            <a href="https://github.com/maheen-2763/moneytracker" target="_blank"
                class="inline-flex items-center gap-2 px-8 py-3.5 rounded-xl
                      font-bold text-slate-200 no-underline
                      bg-white/5 border border-white/10
                      hover:bg-white/10 transition">
                ⭐ GitHub
            </a>
        </div>

        {{-- Stats --}}
        <div class="flex flex-wrap items-center justify-center gap-12 mt-16 animate-fade-up"
            style="animation-delay:0.4s">
            @foreach ([['57', 'Tests Passing'], ['117', 'Assertions'], ['15+', 'Features'], ['100%', 'Auth Secure']] as $s)
                <div class="text-center">
                    <p class="text-3xl font-extrabold text-indigo-300 font-mono-space tracking-tight">
                        {{ $s[0] }}
                    </p>
                    <p class="text-xs text-slate-600 uppercase tracking-widest mt-1">
                        {{ $s[1] }}
                    </p>
                </div>
            @endforeach
        </div>

        {{-- Dashboard Preview --}}
        <div
            class="reveal animate-float mt-16 w-full max-w-2xl
                    bg-slate-800/80 border border-indigo-500/20
                    rounded-2xl p-6 backdrop-blur-xl
                    shadow-[0_40px_80px_rgba(0,0,0,0.4)]">

            {{-- Browser bar --}}
            <div class="flex items-center gap-2 mb-5">
                <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
                <div class="w-2.5 h-2.5 rounded-full bg-yellow-500"></div>
                <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
                <div
                    class="flex-1 bg-white/5 rounded-md h-5 flex items-center
                            px-3 text-[10px] text-slate-600 font-mono-space ml-2">
                    moneytracker.app/dashboard
                </div>
            </div>

            {{-- Mini stats --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-3">
                @foreach ([['Total Spent', '₹25,430', '#ef4444'], ['This Month', '₹4,200', '#6366f1'], ['This Week', '₹850', '#22c55e'], ['Expenses', '47', '#f59e0b']] as $c)
                    <div class="bg-white/[0.04] rounded-xl p-3">
                        <p class="text-[10px] text-slate-500 uppercase tracking-wider">{{ $c[0] }}</p>
                        <p class="text-sm font-extrabold font-mono-space mt-1" style="color:{{ $c[2] }}">
                            {{ $c[1] }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Mini chart --}}
            <div class="bg-white/[0.03] rounded-xl p-4">
                <p class="text-[10px] text-slate-500 mb-3">Monthly Spending Trend</p>
                <div class="flex items-end gap-1 h-12">
                    @foreach ([30, 55, 40, 70, 45, 85, 60, 90, 50, 75, 65, 100] as $i => $h)
                        <div class="flex-1 rounded-t-sm transition-all"
                            style="height:{{ $h }}%;
                                    background:{{ $i === 11 ? 'linear-gradient(180deg,#6366f1,#8b5cf6)' : 'rgba(99,102,241,0.2)' }}">
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </section>

    {{-- ── FEATURES ── --}}
    <section id="features" class="relative z-10 py-24 px-6">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-14 reveal">
                <p class="text-xs font-bold uppercase tracking-widest text-indigo-500 font-mono-space mb-3">
                    Features
                </p>
                <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight leading-tight">
                    Everything you need to<br>
                    <span class="shimmer">manage your money.</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ([['💸', 'Expense Tracking', 'Log every rupee with categories, notes, and receipts. Full CRUD with soft delete.'], ['📊', 'Smart Dashboard', 'Live Chart.js charts showing monthly trends, category breakdowns, and weekly summaries.'], ['🏷️', 'Budget Limits', 'Set monthly limits per category. Get visual warnings before you overspend.'], ['🔔', 'Smart Alerts', 'Bell notifications + email alerts the moment you exceed a budget.'], ['📈', 'Reports & Export', 'Filter by date and category. Export to PDF or Excel in one click.'], ['🔒', '2FA Security', 'Google Authenticator support keeps your financial data locked tight.'], ['🛡️', 'Admin Panel', 'Separate admin guard with full user management, stats, and audit views.'], ['🌐', 'REST API', 'Sanctum-authenticated API with interactive docs at /api/docs.']] as $f)
                    <div
                        class="feature-card reveal cursor-pointer
                                bg-slate-800/50 border border-white/[0.06]
                                rounded-2xl p-6
                                hover:bg-indigo-500/10 hover:border-indigo-500/40
                                hover:-translate-y-1
                                transition-all duration-300">
                        <p class="text-3xl mb-3">{{ $f[0] }}</p>
                        <p class="font-bold text-sm text-slate-200 mb-2 feature-title">{{ $f[1] }}</p>
                        <p class="text-xs text-slate-500 leading-relaxed">{{ $f[2] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── STACK ── --}}
    <section id="stack" class="relative z-10 py-24 px-6 bg-slate-900/60">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-14 reveal">
                <p class="text-xs font-bold uppercase tracking-widest text-indigo-500 font-mono-space mb-3">
                    Tech Stack
                </p>
                <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight leading-tight">
                    Built with the <span class="shimmer">right tools.</span>
                </h2>
            </div>

            <div class="flex flex-wrap justify-center gap-3 mb-12 reveal">
                @foreach ([['Laravel 11', '#FF2D20'], ['PHP 8.2', '#777BB4'], ['MySQL', '#00758F'], ['Tailwind CSS', '#38bdf8'], ['Chart.js', '#FF6384'], ['PestPHP', '#22c55e'], ['Sanctum', '#f59e0b'], ['DomPDF', '#6366f1']] as $s)
                    <div class="px-5 py-2.5 rounded-xl font-bold text-sm font-mono-space
                                bg-white/[0.04] border border-white/[0.08]
                                hover:bg-white/[0.08] transition cursor-default"
                        style="color:{{ $s[1] }}">
                        {{ $s[0] }}
                    </div>
                @endforeach
            </div>

            {{-- Code block --}}
            <div
                class="reveal bg-[#020617] border border-indigo-500/20
                        rounded-2xl p-6 font-mono-space text-xs leading-8
                        max-w-xl mx-auto">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-2 h-2 rounded-full bg-red-500"></div>
                    <div class="w-2 h-2 rounded-full bg-yellow-500"></div>
                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                    <span class="text-slate-700 text-[10px] ml-1">ExpenseController.php</span>
                </div>
                <div><span class="text-indigo-400">public function</span> <span
                        class="text-blue-300">store</span><span class="text-slate-200">(StoreExpenseRequest
                    </span><span class="text-yellow-400">$request</span><span class="text-slate-200">)</span></div>
                <div><span class="text-slate-200">{</span></div>
                <div class="pl-6"><span class="text-slate-600">// Validated, authorized, service layer</span></div>
                <div class="pl-6"><span class="text-yellow-400">$expense</span> <span class="text-slate-200">=
                    </span><span class="text-green-400">$this</span><span
                        class="text-slate-200">->service->create(...);</span></div>
                <div class="pl-6"><span class="text-green-400">$this</span><span
                        class="text-slate-200">->checkBudget(</span><span class="text-yellow-400">$data</span><span
                        class="text-slate-200">['category']);</span></div>
                <div class="pl-6"><span class="text-indigo-400">return</span> <span
                        class="text-slate-200">redirect()->route(</span><span
                        class="text-green-400">'expenses.index'</span><span class="text-slate-200">);</span></div>
                <div><span class="text-slate-200">}</span></div>
            </div>
        </div>
    </section>

    {{-- ── API ── --}}
    <section id="api" class="relative z-10 py-24 px-6">
        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center reveal">
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-indigo-500 font-mono-space mb-3">
                        REST API
                    </p>
                    <h2 class="text-4xl font-extrabold tracking-tight leading-tight mb-4">
                        Full API with<br><span class="shimmer">interactive docs.</span>
                    </h2>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">
                        Every feature exposed via a clean REST API. Token-based auth with Laravel Sanctum.
                        Interactive documentation at
                        <a href="{{ route('api.docs') }}"
                            class="text-indigo-400 font-mono-space no-underline">/api/docs</a>.
                    </p>

                    <div class="space-y-0 divide-y divide-white/[0.05]">
                        @foreach ([['GET', '/api/v1/expenses', 'bg-green-500/10 text-green-400'], ['POST', '/api/v1/expenses', 'bg-blue-500/10 text-blue-400'], ['GET', '/api/v1/budgets', 'bg-green-500/10 text-green-400'], ['GET', '/api/v1/dashboard', 'bg-green-500/10 text-green-400'], ['POST', '/api/v1/login', 'bg-blue-500/10 text-blue-400'], ['DELETE', '/api/v1/expenses/{id}', 'bg-red-500/10 text-red-400']] as $r)
                            <div class="flex items-center gap-3 py-2.5">
                                <span
                                    class="px-2 py-0.5 rounded text-[10px] font-extrabold font-mono-space min-w-[52px] text-center {{ $r[2] }}">
                                    {{ $r[0] }}
                                </span>
                                <span class="text-xs text-slate-400 font-mono-space">{{ $r[1] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- JSON preview --}}
                <div
                    class="bg-[#020617] border border-indigo-500/20
                            rounded-2xl p-6 font-mono-space text-xs leading-8">
                    <div class="text-slate-600 mb-2">// GET /api/v1/dashboard</div>
                    <div><span class="text-slate-200">{</span></div>
                    <div class="pl-6"><span class="text-blue-300">"summary"</span><span class="text-slate-200">:
                            {</span></div>
                    <div class="pl-12"><span class="text-blue-300">"total_all_time"</span><span
                            class="text-slate-200">: </span><span class="text-yellow-400">25430.50</span><span
                            class="text-slate-200">,</span></div>
                    <div class="pl-12"><span class="text-blue-300">"this_month"</span><span class="text-slate-200">:
                        </span><span class="text-yellow-400">4200.00</span><span class="text-slate-200">,</span></div>
                    <div class="pl-12"><span class="text-blue-300">"total_expenses"</span><span
                            class="text-slate-200">: </span><span class="text-yellow-400">47</span></div>
                    <div class="pl-6"><span class="text-slate-200">},</span></div>
                    <div class="pl-6"><span class="text-blue-300">"by_category"</span><span
                            class="text-slate-200">: [...],</span></div>
                    <div class="pl-6"><span class="text-blue-300">"by_month"</span><span class="text-slate-200">:
                            [...]</span></div>
                    <div><span class="text-slate-200">}</span></div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── TESTS ── --}}
    <section id="tests" class="relative z-10 py-24 px-6 bg-slate-900/60">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-14 reveal">
                <p class="text-xs font-bold uppercase tracking-widest text-green-500 font-mono-space mb-3">
                    Testing
                </p>
                <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight">
                    <span class="text-green-400">57 tests.</span> All passing.
                </h2>
            </div>

            <div
                class="reveal bg-[#020617] border border-green-500/20
                        rounded-2xl p-8 font-mono-space text-xs max-w-2xl mx-auto">
                <div class="space-y-0 divide-y divide-white/[0.04]">
                    @foreach ([['Tests\\Feature\\ProfileTest', 16], ['Tests\\Feature\\BudgetTest', 6], ['Tests\\Feature\\ExpenseTest', 7], ['Tests\\Feature\\NotificationTest', 3], ['Tests\\Feature\\Auth', 19], ['Tests\\Unit\\BudgetTest', 5]] as $t)
                        <div class="flex items-center gap-4 py-3">
                            <span class="text-green-400">✓</span>
                            <span class="text-slate-500 flex-1">{{ $t[0] }}</span>
                            <span class="text-green-400 text-[10px]">{{ $t[1] }} tests</span>
                        </div>
                    @endforeach
                </div>

                <div class="mt-5 pt-4 border-t border-green-500/20 text-green-400 font-bold">
                    Tests: <span class="text-white">57 passed</span>
                    · Assertions: <span class="text-white">117</span>
                    · Duration: <span class="text-white">5.68s</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ── CTA ── --}}
    <section id="cta" class="relative z-10 py-24 px-6 text-center overflow-hidden">
        <div
            class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(99,102,241,0.12)_0%,transparent_70%)] pointer-events-none">
        </div>

        <div class="relative max-w-xl mx-auto reveal">
            <p class="text-xs font-bold uppercase tracking-widest text-indigo-500 font-mono-space mb-4">
                Open Source · Portfolio Project
            </p>
            <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4">
                Ready to explore?
            </h2>
            <p class="text-slate-500 text-base leading-relaxed max-w-md mx-auto mb-10">
                Built with clean architecture, tested thoroughly, and documented professionally.
                A real-world Laravel app ready for production.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center gap-2 px-8 py-3.5 rounded-xl
                              font-bold text-white no-underline
                              bg-gradient-to-r from-indigo-500 to-violet-500
                              shadow-xl shadow-indigo-500/30
                              hover:-translate-y-0.5 transition-all duration-200">
                        🚀 Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center gap-2 px-8 py-3.5 rounded-xl
                              font-bold text-white no-underline
                              bg-gradient-to-r from-indigo-500 to-violet-500
                              shadow-xl shadow-indigo-500/30
                              hover:-translate-y-0.5 transition-all duration-200">
                        🚀 Get Started Free
                    </a>
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-2 px-8 py-3.5 rounded-xl
                              font-bold text-slate-200 no-underline
                              bg-white/5 border border-white/10
                              hover:bg-white/10 transition">
                        Sign In
                    </a>
                @endauth
            </div>
        </div>
    </section>

    {{-- ── FOOTER ── --}}
    <footer
        class="relative z-10 py-8 px-6 text-center
                   border-t border-white/[0.05]
                   text-xs text-slate-600">
        Built with ❤️ by
        <span class="text-indigo-500">Mohammed Maheen Afzal</span>
        · Laravel 11 · MIT License ·
        <a href="{{ route('api.docs') }}" class="text-indigo-500 no-underline hover:text-indigo-400 transition">
            API Docs
        </a>
    </footer>

    <script>
        // Scroll reveal
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) e.target.classList.add('visible');
            });
        }, {
            threshold: 0.1
        });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // Navbar scroll
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 40) {
                nav.classList.add('bg-[#050914]/85', 'backdrop-blur-xl', 'border-b', 'border-indigo-500/15');
            } else {
                nav.classList.remove('bg-[#050914]/85', 'backdrop-blur-xl', 'border-b', 'border-indigo-500/15');
            }
        });

        // Feature cards auto-rotate
        const cards = document.querySelectorAll('.feature-card');
        let current = 0;
        setInterval(() => {
            cards.forEach(c => c.classList.remove('bg-indigo-500/10', 'border-indigo-500/40', '-translate-y-1'));
            cards[current].classList.add('bg-indigo-500/10', 'border-indigo-500/40', '-translate-y-1');
            current = (current + 1) % cards.length;
        }, 2500);
    </script>

</body>

</html>
