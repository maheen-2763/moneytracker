@extends('layouts.app')

@section('title', 'MoneyTracker - Personal Finance Made Simple')

@section('content')
    <style>
        :root {
            --primary-color: #3b82f6;
            --primary-dark: #1e40af;
            --secondary-color: #f3f4f6;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --primary-color: #60a5fa;
                --secondary-color: #1f2937;
                --text-primary: #f3f4f6;
                --text-secondary: #d1d5db;
                --border-color: #374151;
            }
        }

        body {
            background-color: var(--secondary-color);
            color: var(--text-primary);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
        }

        .landing-header {
            background-color: white;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        @media (prefers-color-scheme: dark) {
            .landing-header {
                background-color: #111827;
            }
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.25rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: var(--text-primary);
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-primary);
            font-size: 0.875rem;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary-color);
        }

        .btn {
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            cursor: pointer;
            border: none;
            transition: all 0.3s;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-secondary {
            background: transparent;
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: var(--secondary-color);
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .btn-lg {
            padding: 0.875rem 1.75rem;
            font-size: 1rem;
        }

        .hero-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 5rem 1.25rem;
            text-align: center;
        }

        .hero-title {
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.125rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 3rem;
        }

        .hero-demo {
            background: linear-gradient(135deg, var(--secondary-color) 0%, rgba(59, 130, 246, 0.05) 100%);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 2.5rem;
            margin-bottom: 1.5rem;
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .demo-credentials {
            font-size: 0.75rem;
            color: var(--text-secondary);
            margin-top: 1rem;
            font-family: 'Courier New', monospace;
        }

        .features-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 5rem 1.25rem;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 3rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            padding: 2rem;
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            background: white;
            transition: all 0.3s;
        }

        @media (prefers-color-scheme: dark) {
            .feature-card {
                background: #1f2937;
            }
        }

        .feature-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        @media (prefers-color-scheme: dark) {
            .feature-card:hover {
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            }
        }

        .feature-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .feature-card p {
            font-size: 0.875rem;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .tech-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 5rem 1.25rem;
        }

        .tech-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
        }

        .tech-item {
            text-align: center;
            padding: 1.5rem;
            border-radius: 0.5rem;
            background: white;
            border: 1px solid var(--border-color);
            transition: all 0.3s;
        }

        @media (prefers-color-scheme: dark) {
            .tech-item {
                background: #1f2937;
            }
        }

        .tech-item:hover {
            border-color: var(--primary-color);
        }

        .tech-item-icon {
            font-size: 1.75rem;
            margin-bottom: 0.75rem;
        }

        .tech-item h4 {
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .tech-item p {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        .cta-section {
            max-width: 1200px;
            margin: 2.5rem auto;
            padding: 3rem;
            text-align: center;
            background: white;
            border-radius: 0.75rem;
            border: 1px solid var(--border-color);
        }

        @media (prefers-color-scheme: dark) {
            .cta-section {
                background: #1f2937;
            }
        }

        .cta-section h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .cta-section p {
            font-size: 1rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
        }

        .landing-footer {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2.5rem 1.25rem;
            border-top: 1px solid var(--border-color);
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .footer-links {
            margin-top: 0.75rem;
            font-size: 0.75rem;
        }

        .footer-links a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--primary-color);
        }

        .footer-links a+a::before {
            content: ' • ';
            margin: 0 0.5rem;
        }

        @media (max-width: 768px) {
            .nav-links {
                gap: 1rem;
            }

            .nav-links a {
                font-size: 0.75rem;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .hero-buttons .btn {
                width: 100%;
            }

            .hero-title {
                font-size: 1.75rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .tech-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .cta-section {
                margin: 1.5rem 1.25rem;
            }

            .cta-section .hero-buttons {
                flex-direction: column;
            }

            .cta-section .btn {
                width: 100%;
            }
        }

        @media (max-width: 640px) {
            .header-content {
                padding: 1rem;
            }

            .nav-links {
                display: none;
            }



            .hero-section {
                padding: 3rem 1rem;
            }

            .hero-demo {
                padding: 1.5rem;
            }

            .tech-grid {
                grid-template-columns: 1fr;
            }
        }

        .hero-demo img {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hero-demo img:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.2);
        }
    </style>

    <!-- Header Navigation -->
    <header class="landing-header">
        <div class="header-content">
            <a href="{{ route('landing') }}" class="logo">
                <span>💰</span>
                MoneyTracker
            </a>
            <nav class="nav-links">
                <a href="#features">Features</a>
                <a href="#tech">Tech Stack</a>
                <a href="https://github.com/maheen-2763/moneytracker.git" target="_blank" rel="noopener">GitHub</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Try Demo</a>
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <h1 class="hero-title">Take Control of Your Money</h1>
        <p class="hero-subtitle">
            Track expenses, set budgets, and get real-time alerts. MoneyTracker is the simple, powerful way to manage your
            personal finances.
        </p>

        <div class="hero-demo">
            <img src="{{ asset('images/dashboard-screenshot.png') }}" alt="MoneyTracker Dashboard" loading="lazy"
                style="max-width: 100%; 
                width: 100%; 
                height: auto; 
                border-radius: 0.75rem; 
                box-shadow: 0 10px 25px rgba(0,0,0,0.1);
                border: 1px solid var(--border-color);">
        </div>

        <div class="hero-buttons">
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Try Live Demo</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary btn-lg">Sign Up Free</a>
                @endauth
            @endif
            <a href="https://github.com/yourusername/moneytracker#-local-setup" target="_blank" rel="noopener"
                class="btn btn-secondary btn-lg">📦 Install Locally</a>
            <a href="https://github.com/maheen-2763/moneytracker" target="_blank" rel="noopener"
                class="btn btn-secondary btn-lg">⭐ View on GitHub</a>
        </div>

    </section>

    <!-- Features Section -->
    <section id="features" class="features-section">
        <h2 class="section-title">Powerful Features</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🔐</div>
                <h3>Secure Authentication</h3>
                <p>Register and log in securely using Laravel Breeze. Your financial data is protected and private.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💸</div>
                <h3>Expense Tracking</h3>
                <p>Create, edit, and manage expenses with full CRUD operations. Soft deletes keep your history intact.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Smart Dashboard</h3>
                <p>Visual summary cards, category breakdowns, and monthly charts give you instant insights.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📈</div>
                <h3>Detailed Reports</h3>
                <p>Filter by date and category. Export reports to PDF or Excel for further analysis.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🏷️</div>
                <h3>Budget Management</h3>
                <p>Set monthly spending limits per category with real-time progress tracking.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔔</div>
                <h3>Smart Notifications</h3>
                <p>Get instant alerts when you exceed budget limits. Stay informed with bell icon notifications.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">👤</div>
                <h3>Profile Management</h3>
                <p>Upload avatars, edit your information, and change your password anytime.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🌙</div>
                <h3>Dark Mode</h3>
                <p>Switch between light and dark modes. Your preference persists with localStorage.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📱</div>
                <h3>Fully Responsive</h3>
                <p>Works perfectly on desktop, tablet, and mobile with a smooth slide-in sidebar.</p>
            </div>
        </div>
    </section>

    <!-- Tech Stack Section -->
    <section id="tech" class="tech-section">
        <h2 class="section-title">Built with Modern Tech</h2>
        <div class="tech-grid">
            <div class="tech-item">
                <div class="tech-item-icon">⚙️</div>
                <h4>Laravel 11</h4>
                <p>Powerful PHP framework</p>
            </div>
            <div class="tech-item">
                <div class="tech-item-icon">🎨</div>
                <h4>Bootstrap 5</h4>
                <p>Responsive frontend</p>
            </div>
            <div class="tech-item">
                <div class="tech-item-icon">🗄️</div>
                <h4>MySQL</h4>
                <p>Reliable database</p>
            </div>
            <div class="tech-item">
                <div class="tech-item-icon">📄</div>
                <h4>DomPDF</h4>
                <p>PDF exports</p>
            </div>
            <div class="tech-item">
                <div class="tech-item-icon">📊</div>
                <h4>Excel Export</h4>
                <p>Data analysis</p>
            </div>
            <div class="tech-item">
                <div class="tech-item-icon">🧪</div>
                <h4>PestPHP</h4>
                <p>57 comprehensive tests</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <div class="hero-section">
        <section class="cta-section">
            <h2>Ready to Take Control?</h2>
            <p>Start tracking your finances today with our live demo. No credit card required.</p>
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Try Live Demo Now</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary btn-lg">Create Free Account</a>
                @endauth
            @endif
        </section>
    </div>

    <!-- Footer -->
    <footer class="landing-footer">
        <p>&copy; {{ date('Y') }} MoneyTracker. Built by Mohammed Maheen Afzal.</p>
        <div class="footer-links">
            <a href="https://github.com/maheen-2763" target="_blank" rel="noopener">GitHub</a>
            <a href="https://linkedin.com/in/yourprofile" target="_blank" rel="noopener">LinkedIn</a>
            <a href="mailto:your@email.com">Email</a>
        </div>
    </footer>

@endsection
