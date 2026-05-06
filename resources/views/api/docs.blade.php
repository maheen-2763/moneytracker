<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoneyTracker API Docs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap"
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
            color: #e2e8f0;
            display: flex;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .docs-sidebar {
            width: 260px;
            background: #020617;
            border-right: 1px solid #1e293b;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
        }

        .docs-brand {
            padding: 1.5rem;
            border-bottom: 1px solid #1e293b;
        }

        .docs-brand h1 {
            font-size: 1rem;
            font-weight: 800;
            color: #fff;
            margin: 0;
        }

        .docs-brand .version {
            font-size: 0.7rem;
            background: #6366f1;
            color: #fff;
            padding: 0.15rem 0.5rem;
            border-radius: 20px;
            font-weight: 700;
            margin-left: 0.5rem;
        }

        .docs-brand p {
            font-size: 0.72rem;
            color: #475569;
            margin-top: 0.35rem;
        }

        .nav-section-title {
            font-size: 0.62rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #334155;
            padding: 1rem 1.25rem 0.3rem;
        }

        .docs-nav-link {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.5rem 1.25rem;
            font-size: 0.82rem;
            font-weight: 500;
            color: #64748b;
            text-decoration: none;
            border-left: 2px solid transparent;
            transition: all 0.15s;
        }

        .docs-nav-link:hover {
            color: #e2e8f0;
            background: #0f172a;
        }

        .docs-nav-link.active {
            color: #a5b4fc;
            border-left-color: #6366f1;
            background: #0f172a;
        }

        .method-pill {
            font-size: 0.6rem;
            font-weight: 800;
            padding: 0.1rem 0.4rem;
            border-radius: 4px;
            font-family: 'JetBrains Mono', monospace;
        }

        .pill-get {
            background: #166534;
            color: #bbf7d0;
        }

        .pill-post {
            background: #1e3a5f;
            color: #93c5fd;
        }

        .pill-put {
            background: #713f12;
            color: #fde68a;
        }

        .pill-delete {
            background: #7f1d1d;
            color: #fecaca;
        }

        /* ── Main Content ── */
        .docs-main {
            margin-left: 260px;
            flex: 1;
            max-width: 900px;
            padding: 2.5rem 3rem;
        }

        /* ── Sections ── */
        .docs-section {
            margin-bottom: 3rem;
            scroll-margin-top: 2rem;
        }

        .docs-section h2 {
            font-size: 1.4rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #1e293b;
        }

        .docs-section h3 {
            font-size: 1rem;
            font-weight: 700;
            color: #e2e8f0;
            margin: 1.5rem 0 0.75rem;
        }

        .docs-section p {
            font-size: 0.875rem;
            color: #94a3b8;
            line-height: 1.7;
            margin-bottom: 1rem;
        }

        /* ── Endpoint Card ── */
        .endpoint-card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 12px;
            margin-bottom: 1rem;
            overflow: hidden;
        }

        .endpoint-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 1.25rem;
            cursor: pointer;
            transition: background 0.15s;
        }

        .endpoint-header:hover {
            background: #263348;
        }

        .endpoint-method {
            font-size: 0.72rem;
            font-weight: 800;
            padding: 0.25rem 0.6rem;
            border-radius: 6px;
            font-family: 'JetBrains Mono', monospace;
            min-width: 60px;
            text-align: center;
        }

        .method-GET {
            background: #14532d;
            color: #4ade80;
        }

        .method-POST {
            background: #1e3a5f;
            color: #60a5fa;
        }

        .method-PUT {
            background: #713f12;
            color: #fbbf24;
        }

        .method-DELETE {
            background: #7f1d1d;
            color: #f87171;
        }

        .endpoint-path {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.875rem;
            color: #e2e8f0;
            flex: 1;
        }

        .endpoint-desc {
            font-size: 0.78rem;
            color: #64748b;
        }

        .endpoint-auth {
            font-size: 0.65rem;
            padding: 0.15rem 0.5rem;
            border-radius: 20px;
            font-weight: 700;
            background: #422006;
            color: #fb923c;
        }

        .endpoint-auth.public {
            background: #14532d;
            color: #4ade80;
        }

        .endpoint-body {
            padding: 1.25rem;
            border-top: 1px solid #334155;
            display: none;
        }

        .endpoint-body.show {
            display: block;
        }

        /* ── Code Block ── */
        .code-block {
            background: #020617;
            border: 1px solid #1e293b;
            border-radius: 8px;
            padding: 1rem 1.25rem;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.78rem;
            color: #94a3b8;
            overflow-x: auto;
            position: relative;
            margin-bottom: 1rem;
        }

        .code-block .key {
            color: #a5b4fc;
        }

        .code-block .str {
            color: #86efac;
        }

        .code-block .num {
            color: #fbbf24;
        }

        .code-block .bool {
            color: #f87171;
        }

        .code-block .comment {
            color: #334155;
        }

        .copy-btn {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: #1e293b;
            border: 1px solid #334155;
            color: #64748b;
            font-size: 0.65rem;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .copy-btn:hover {
            color: #e2e8f0;
        }

        /* ── Params Table ── */
        .params-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8rem;
            margin-bottom: 1rem;
        }

        .params-table th {
            text-align: left;
            padding: 0.5rem 0.75rem;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #475569;
            border-bottom: 1px solid #334155;
        }

        .params-table td {
            padding: 0.6rem 0.75rem;
            border-bottom: 1px solid #1e293b;
            color: #94a3b8;
            vertical-align: top;
        }

        .params-table td:first-child {
            font-family: 'JetBrains Mono', monospace;
            color: #a5b4fc;
            font-size: 0.78rem;
        }

        .required-badge {
            font-size: 0.6rem;
            background: #7f1d1d;
            color: #fecaca;
            padding: 0.1rem 0.35rem;
            border-radius: 4px;
            font-weight: 700;
            margin-left: 0.3rem;
        }

        .optional-badge {
            font-size: 0.6rem;
            background: #1e293b;
            color: #64748b;
            padding: 0.1rem 0.35rem;
            border-radius: 4px;
            font-weight: 700;
            margin-left: 0.3rem;
        }

        /* ── Alert box ── */
        .docs-alert {
            border-radius: 8px;
            padding: 0.85rem 1rem;
            font-size: 0.82rem;
            margin-bottom: 1rem;
            display: flex;
            gap: 0.65rem;
            align-items: flex-start;
        }

        .docs-alert.info {
            background: #172554;
            border: 1px solid #1e3a8a;
            color: #93c5fd;
        }

        .docs-alert.warning {
            background: #422006;
            border: 1px solid #7c2d12;
            color: #fdba74;
        }

        /* ── Base URL ── */
        .base-url {
            background: #020617;
            border: 1px solid #1e293b;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.875rem;
            color: #6366f1;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>

    {{-- ── Sidebar ── --}}
    <aside class="docs-sidebar">
        <div class="docs-brand">
            <h1>
                <i class="bi bi-wallet2 me-1" style="color:#6366f1;"></i>
                MoneyTracker API
                <span class="version">v1</span>
            </h1>
            <p>REST API Documentation</p>
        </div>

        <div class="nav-section-title">Getting Started</div>
        <a href="#introduction" class="docs-nav-link active">Introduction</a>
        <a href="#authentication" class="docs-nav-link">Authentication</a>
        <a href="#errors" class="docs-nav-link">Error Handling</a>

        <div class="nav-section-title">Auth Endpoints</div>
        <a href="#register" class="docs-nav-link">
            <span class="method-pill pill-post">POST</span> Register
        </a>
        <a href="#login" class="docs-nav-link">
            <span class="method-pill pill-post">POST</span> Login
        </a>
        <a href="#logout" class="docs-nav-link">
            <span class="method-pill pill-post">POST</span> Logout
        </a>
        <a href="#me" class="docs-nav-link">
            <span class="method-pill pill-get">GET</span> Me
        </a>

        <div class="nav-section-title">Expenses</div>
        <a href="#expenses-list" class="docs-nav-link">
            <span class="method-pill pill-get">GET</span> List
        </a>
        <a href="#expenses-create" class="docs-nav-link">
            <span class="method-pill pill-post">POST</span> Create
        </a>
        <a href="#expenses-show" class="docs-nav-link">
            <span class="method-pill pill-get">GET</span> Show
        </a>
        <a href="#expenses-update" class="docs-nav-link">
            <span class="method-pill pill-put">PUT</span> Update
        </a>
        <a href="#expenses-delete" class="docs-nav-link">
            <span class="method-pill pill-delete">DEL</span> Delete
        </a>

        <div class="nav-section-title">Budgets</div>
        <a href="#budgets-list" class="docs-nav-link">
            <span class="method-pill pill-get">GET</span> List
        </a>
        <a href="#budgets-create" class="docs-nav-link">
            <span class="method-pill pill-post">POST</span> Create
        </a>
        <a href="#budgets-update" class="docs-nav-link">
            <span class="method-pill pill-put">PUT</span> Update
        </a>
        <a href="#budgets-delete" class="docs-nav-link">
            <span class="method-pill pill-delete">DEL</span> Delete
        </a>

        <div class="nav-section-title">Dashboard</div>
        <a href="#dashboard" class="docs-nav-link">
            <span class="method-pill pill-get">GET</span> Summary
        </a>
    </aside>

    {{-- ── Main Content ── --}}
    <main class="docs-main">

        {{-- Introduction --}}
        <section class="docs-section" id="introduction">
            <h2>📖 Introduction</h2>
            <p>
                The MoneyTracker REST API allows you to programmatically manage
                expenses, budgets, and view financial summaries. All API responses
                are returned in <strong style="color:#e2e8f0;">JSON</strong> format.
            </p>

            <h3>Base URL</h3>
            <div class="base-url">
                {{ url('/api/v1') }}
            </div>

            <h3>Request Format</h3>
            <p>All POST/PUT requests must include the following headers:</p>
            <div class="code-block">
                <button class="copy-btn" onclick="copyCode(this)">Copy</button>
                Content-Type: application/json
                Accept: application/json
                Authorization: Bearer {your_token}
            </div>
        </section>

        {{-- Authentication --}}
        <section class="docs-section" id="authentication">
            <h2>🔐 Authentication</h2>
            <p>
                MoneyTracker uses <strong style="color:#e2e8f0;">Laravel Sanctum</strong>
                token-based authentication. After logging in, you receive a
                Bearer token that must be included in all protected requests.
            </p>

            <div class="docs-alert info">
                <i class="bi bi-info-circle-fill"></i>
                <span>
                    Tokens don't expire by default. Call
                    <code style="color:#a5b4fc;">POST /api/v1/logout</code>
                    to revoke a token.
                </span>
            </div>

            <h3>How to Authenticate</h3>
            <div class="code-block">
                <button class="copy-btn" onclick="copyCode(this)">Copy</button>
                <span class="comment"># Step 1: Login to get your token</span>
                curl -X POST {{ url('/api/v1/login') }} \
                -H "Content-Type: application/json" \
                -d '{"email":"you@example.com","password":"yourpassword"}'

                <span class="comment"># Step 2: Use token in all requests</span>
                curl {{ url('/api/v1/expenses') }} \
                -H "Authorization: Bearer YOUR_TOKEN_HERE"
            </div>
        </section>

        {{-- Error Handling --}}
        <section class="docs-section" id="errors">
            <h2>⚠️ Error Handling</h2>
            <p>All errors return a consistent JSON structure:</p>

            <table class="params-table">
                <thead>
                    <tr>
                        <th>Status Code</th>
                        <th>Meaning</th>
                        <th>When it happens</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>200</td>
                        <td>OK</td>
                        <td>Request succeeded</td>
                    </tr>
                    <tr>
                        <td>201</td>
                        <td>Created</td>
                        <td>Resource created successfully</td>
                    </tr>
                    <tr>
                        <td>401</td>
                        <td>Unauthenticated</td>
                        <td>Missing or invalid token</td>
                    </tr>
                    <tr>
                        <td>403</td>
                        <td>Forbidden</td>
                        <td>Accessing another user's resource</td>
                    </tr>
                    <tr>
                        <td>404</td>
                        <td>Not Found</td>
                        <td>Resource doesn't exist</td>
                    </tr>
                    <tr>
                        <td>422</td>
                        <td>Validation Error</td>
                        <td>Invalid request data</td>
                    </tr>
                    <tr>
                        <td>429</td>
                        <td>Too Many Requests</td>
                        <td>Rate limit exceeded</td>
                    </tr>
                </tbody>
            </table>

            <h3>Error Response Example</h3>
            <div class="code-block">
                {
                <span class="key">"message"</span>: <span class="str">"The given data was invalid."</span>,
                <span class="key">"errors"</span>: {
                <span class="key">"email"</span>: [<span class="str">"The email field is required."</span>],
                <span class="key">"amount"</span>: [<span class="str">"The amount must be a number."</span>]
                }
                }
            </div>
        </section>

        {{-- ═══════════════════════════════════
         AUTH ENDPOINTS
    ════════════════════════════════════ --}}

        <section class="docs-section" id="register">
            <h2>👤 Register</h2>
            <div class="endpoint-card">
                <div class="endpoint-header" onclick="toggle(this)">
                    <span class="endpoint-method method-POST">POST</span>
                    <span class="endpoint-path">/api/v1/register</span>
                    <span class="endpoint-desc">Create a new account</span>
                    <span class="endpoint-auth public">Public</span>
                    <i class="bi bi-chevron-down ms-2" style="color:#64748b; font-size:.75rem;"></i>
                </div>
                <div class="endpoint-body">
                    <h3>Request Body</h3>
                    <table class="params-table">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Type</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>name <span class="required-badge">required</span></td>
                                <td>string</td>
                                <td>Full name, max 255 chars</td>
                            </tr>
                            <tr>
                                <td>email <span class="required-badge">required</span></td>
                                <td>string</td>
                                <td>Valid unique email address</td>
                            </tr>
                            <tr>
                                <td>password <span class="required-badge">required</span></td>
                                <td>string</td>
                                <td>Min 8 characters</td>
                            </tr>
                            <tr>
                                <td>password_confirmation <span class="required-badge">required</span></td>
                                <td>string</td>
                                <td>Must match password</td>
                            </tr>
                        </tbody>
                    </table>

                    <h3>Example Request</h3>
                    <div class="code-block">
                        <button class="copy-btn" onclick="copyCode(this)">Copy</button>
                        curl -X POST {{ url('/api/v1/register') }} \
                        -H "Content-Type: application/json" \
                        -d '{
                        <span class="key">"name"</span>: <span class="str">"John Doe"</span>,
                        <span class="key">"email"</span>: <span class="str">"john@example.com"</span>,
                        <span class="key">"password"</span>: <span class="str">"password123"</span>,
                        <span class="key">"password_confirmation"</span>: <span class="str">"password123"</span>
                        }'
                    </div>

                    <h3>Response <span style="color:#4ade80; font-size:.75rem;">201 Created</span></h3>
                    <div class="code-block">
                        {
                        <span class="key">"message"</span>: <span class="str">"Registration successful."</span>,
                        <span class="key">"token"</span>: <span class="str">"1|abc123xyz..."</span>,
                        <span class="key">"user"</span>: {
                        <span class="key">"id"</span>: <span class="num">1</span>,
                        <span class="key">"name"</span>: <span class="str">"John Doe"</span>,
                        <span class="key">"email"</span>: <span class="str">"john@example.com"</span>,
                        <span class="key">"avatar_url"</span>: <span
                            class="str">"https://ui-avatars.com/..."</span>,
                        <span class="key">"joined_at"</span>: <span class="str">"06 May 2026"</span>
                        }
                        }
                    </div>
                </div>
            </div>
        </section>

        <section class="docs-section" id="login">
            <h2>🔑 Login</h2>
            <div class="endpoint-card">
                <div class="endpoint-header" onclick="toggle(this)">
                    <span class="endpoint-method method-POST">POST</span>
                    <span class="endpoint-path">/api/v1/login</span>
                    <span class="endpoint-desc">Get authentication token</span>
                    <span class="endpoint-auth public">Public</span>
                    <i class="bi bi-chevron-down ms-2" style="color:#64748b; font-size:.75rem;"></i>
                </div>
                <div class="endpoint-body">
                    <h3>Request Body</h3>
                    <table class="params-table">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Type</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>email <span class="required-badge">required</span></td>
                                <td>string</td>
                                <td>Registered email address</td>
                            </tr>
                            <tr>
                                <td>password <span class="required-badge">required</span></td>
                                <td>string</td>
                                <td>Account password</td>
                            </tr>
                        </tbody>
                    </table>

                    <h3>Example Request</h3>
                    <div class="code-block">
                        <button class="copy-btn" onclick="copyCode(this)">Copy</button>
                        curl -X POST {{ url('/api/v1/login') }} \
                        -H "Content-Type: application/json" \
                        -d '{
                        <span class="key">"email"</span>: <span class="str">"john@example.com"</span>,
                        <span class="key">"password"</span>: <span class="str">"password123"</span>
                        }'
                    </div>

                    <h3>Response <span style="color:#4ade80; font-size:.75rem;">200 OK</span></h3>
                    <div class="code-block">
                        {
                        <span class="key">"message"</span>: <span class="str">"Login successful."</span>,
                        <span class="key">"token"</span>: <span class="str">"2|xyz789abc..."</span>,
                        <span class="key">"user"</span>: {
                        <span class="key">"id"</span>: <span class="num">1</span>,
                        <span class="key">"name"</span>: <span class="str">"John Doe"</span>,
                        <span class="key">"email"</span>: <span class="str">"john@example.com"</span>
                        }
                        }
                    </div>
                </div>
            </div>
        </section>

        <section class="docs-section" id="logout">
            <h2>🚪 Logout</h2>
            <div class="endpoint-card">
                <div class="endpoint-header" onclick="toggle(this)">
                    <span class="endpoint-method method-POST">POST</span>
                    <span class="endpoint-path">/api/v1/logout</span>
                    <span class="endpoint-desc">Revoke current token</span>
                    <span class="endpoint-auth">🔒 Auth Required</span>
                    <i class="bi bi-chevron-down ms-2" style="color:#64748b; font-size:.75rem;"></i>
                </div>
                <div class="endpoint-body">
                    <h3>Example Request</h3>
                    <div class="code-block">
                        <button class="copy-btn" onclick="copyCode(this)">Copy</button>
                        curl -X POST {{ url('/api/v1/logout') }} \
                        -H "Authorization: Bearer YOUR_TOKEN"
                    </div>
                    <h3>Response <span style="color:#4ade80; font-size:.75rem;">200 OK</span></h3>
                    <div class="code-block">
                        {
                        <span class="key">"message"</span>: <span class="str">"Logged out successfully."</span>
                        }
                    </div>
                </div>
            </div>
        </section>

        <section class="docs-section" id="me">
            <h2>👤 Current User</h2>
            <div class="endpoint-card">
                <div class="endpoint-header" onclick="toggle(this)">
                    <span class="endpoint-method method-GET">GET</span>
                    <span class="endpoint-path">/api/v1/me</span>
                    <span class="endpoint-desc">Get authenticated user</span>
                    <span class="endpoint-auth">🔒 Auth Required</span>
                    <i class="bi bi-chevron-down ms-2" style="color:#64748b; font-size:.75rem;"></i>
                </div>
                <div class="endpoint-body">
                    <h3>Response <span style="color:#4ade80; font-size:.75rem;">200 OK</span></h3>
                    <div class="code-block">
                        {
                        <span class="key">"user"</span>: {
                        <span class="key">"id"</span>: <span class="num">1</span>,
                        <span class="key">"name"</span>: <span class="str">"John Doe"</span>,
                        <span class="key">"email"</span>: <span class="str">"john@example.com"</span>,
                        <span class="key">"phone"</span>: <span class="str">"+91 9876543210"</span>,
                        <span class="key">"bio"</span>: <span class="str">"Personal finance tracker"</span>,
                        <span class="key">"avatar_url"</span>: <span class="str">"https://..."</span>,
                        <span class="key">"joined_at"</span>: <span class="str">"01 Jan 2026"</span>
                        }
                        }
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════════════
         EXPENSE ENDPOINTS
    ════════════════════════════════════ --}}

        <section class="docs-section" id="expenses-list">
            <h2>💸 List Expenses</h2>
            <div class="endpoint-card">
                <div class="endpoint-header" onclick="toggle(this)">
                    <span class="endpoint-method method-GET">GET</span>
                    <span class="endpoint-path">/api/v1/expenses</span>
                    <span class="endpoint-desc">Paginated list with filters</span>
                    <span class="endpoint-auth">🔒 Auth Required</span>
                    <i class="bi bi-chevron-down ms-2" style="color:#64748b; font-size:.75rem;"></i>
                </div>
                <div class="endpoint-body">
                    <h3>Query Parameters</h3>
                    <table class="params-table">
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Type</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>category <span class="optional-badge">optional</span></td>
                                <td>string</td>
                                <td>food, travel, health, office, other</td>
                            </tr>
                            <tr>
                                <td>start_date <span class="optional-badge">optional</span></td>
                                <td>date</td>
                                <td>Filter from date (Y-m-d)</td>
                            </tr>
                            <tr>
                                <td>end_date <span class="optional-badge">optional</span></td>
                                <td>date</td>
                                <td>Filter to date (Y-m-d)</td>
                            </tr>
                            <tr>
                                <td>page <span class="optional-badge">optional</span></td>
                                <td>integer</td>
                                <td>Page number (default: 1)</td>
                            </tr>
                        </tbody>
                    </table>

                    <h3>Example Request</h3>
                    <div class="code-block">
                        <button class="copy-btn" onclick="copyCode(this)">Copy</button>
                        curl "{{ url('/api/v1/expenses') }}?category=food&start_date=2026-01-01" \
                        -H "Authorization: Bearer YOUR_TOKEN"
                    </div>

                    <h3>Response <span style="color:#4ade80; font-size:.75rem;">200 OK</span></h3>
                    <div class="code-block">
                        {
                        <span class="key">"data"</span>: [
                        {
                        <span class="key">"id"</span>: <span class="num">1</span>,
                        <span class="key">"title"</span>: <span class="str">"Team Lunch"</span>,
                        <span class="key">"amount"</span>: <span class="num">45.50</span>,
                        <span class="key">"category"</span>: <span class="str">"food"</span>,
                        <span class="key">"expense_date"</span>: <span class="str">"2026-05-06"</span>,
                        <span class="key">"notes"</span>: <span class="str">"Office team lunch"</span>,
                        <span class="key">"created_at"</span>: <span class="str">"2026-05-06 10:30:00"</span>
                        }
                        ],
                        <span class="key">"meta"</span>: {
                        <span class="key">"current_page"</span>: <span class="num">1</span>,
                        <span class="key">"per_page"</span>: <span class="num">15</span>,
                        <span class="key">"total"</span>: <span class="num">47</span>,
                        <span class="key">"last_page"</span>: <span class="num">4</span>
                        }
                        }
                    </div>
                </div>
            </div>
        </section>

        <section class="docs-section" id="expenses-create">
            <h2>➕ Create Expense</h2>
            <div class="endpoint-card">
                <div class="endpoint-header" onclick="toggle(this)">
                    <span class="endpoint-method method-POST">POST</span>
                    <span class="endpoint-path">/api/v1/expenses</span>
                    <span class="endpoint-desc">Add a new expense</span>
                    <span class="endpoint-auth">🔒 Auth Required</span>
                    <i class="bi bi-chevron-down ms-2" style="color:#64748b; font-size:.75rem;"></i>
                </div>
                <div class="endpoint-body">
                    <h3>Request Body</h3>
                    <table class="params-table">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Type</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>title <span class="required-badge">required</span></td>
                                <td>string</td>
                                <td>Expense title, max 150 chars</td>
                            </tr>
                            <tr>
                                <td>amount <span class="required-badge">required</span></td>
                                <td>numeric</td>
                                <td>Amount between 0.01 and 999999.99</td>
                            </tr>
                            <tr>
                                <td>category <span class="required-badge">required</span></td>
                                <td>string</td>
                                <td>food, travel, health, office, other</td>
                            </tr>
                            <tr>
                                <td>expense_date <span class="required-badge">required</span></td>
                                <td>date</td>
                                <td>Date format: Y-m-d, cannot be future</td>
                            </tr>
                            <tr>
                                <td>description <span class="optional-badge">optional</span></td>
                                <td>string</td>
                                <td>Additional notes, max 1000 chars</td>
                            </tr>
                        </tbody>
                    </table>

                    <h3>Example Request</h3>
                    <div class="code-block">
                        <button class="copy-btn" onclick="copyCode(this)">Copy</button>
                        curl -X POST {{ url('/api/v1/expenses') }} \
                        -H "Authorization: Bearer YOUR_TOKEN" \
                        -H "Content-Type: application/json" \
                        -d '{
                        <span class="key">"title"</span>: <span class="str">"Team Lunch"</span>,
                        <span class="key">"amount"</span>: <span class="num">45.50</span>,
                        <span class="key">"category"</span>: <span class="str">"food"</span>,
                        <span class="key">"expense_date"</span>: <span class="str">"2026-05-06"</span>,
                        <span class="key">"description"</span>: <span class="str">"Office team lunch"</span>
                        }'
                    </div>

                    <h3>Response <span style="color:#4ade80; font-size:.75rem;">201 Created</span></h3>
                    <div class="code-block">
                        {
                        <span class="key">"message"</span>: <span class="str">"Expense created
                            successfully."</span>,
                        <span class="key">"expense"</span>: {
                        <span class="key">"id"</span>: <span class="num">42</span>,
                        <span class="key">"title"</span>: <span class="str">"Team Lunch"</span>,
                        <span class="key">"amount"</span>: <span class="num">45.50</span>,
                        <span class="key">"category"</span>: <span class="str">"food"</span>,
                        <span class="key">"expense_date"</span>: <span class="str">"2026-05-06"</span>
                        }
                        }
                    </div>
                </div>
            </div>
        </section>

        <section class="docs-section" id="expenses-update">
            <h2>✏️ Update Expense</h2>
            <div class="endpoint-card">
                <div class="endpoint-header" onclick="toggle(this)">
                    <span class="endpoint-method method-PUT">PUT</span>
                    <span class="endpoint-path">/api/v1/expenses/{id}</span>
                    <span class="endpoint-desc">Update an expense</span>
                    <span class="endpoint-auth">🔒 Auth Required</span>
                    <i class="bi bi-chevron-down ms-2" style="color:#64748b; font-size:.75rem;"></i>
                </div>
                <div class="endpoint-body">
                    <div class="docs-alert warning">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <span>You can only update your own expenses. Returns 403 otherwise.</span>
                    </div>

                    <h3>Example Request</h3>
                    <div class="code-block">
                        <button class="copy-btn" onclick="copyCode(this)">Copy</button>
                        curl -X PUT {{ url('/api/v1/expenses/42') }} \
                        -H "Authorization: Bearer YOUR_TOKEN" \
                        -H "Content-Type: application/json" \
                        -d '{
                        <span class="key">"title"</span>: <span class="str">"Updated Lunch"</span>,
                        <span class="key">"amount"</span>: <span class="num">55.00</span>
                        }'
                    </div>
                </div>
            </div>
        </section>

        <section class="docs-section" id="expenses-delete">
            <h2>🗑️ Delete Expense</h2>
            <div class="endpoint-card">
                <div class="endpoint-header" onclick="toggle(this)">
                    <span class="endpoint-method method-DELETE">DELETE</span>
                    <span class="endpoint-path">/api/v1/expenses/{id}</span>
                    <span class="endpoint-desc">Soft delete an expense</span>
                    <span class="endpoint-auth">🔒 Auth Required</span>
                    <i class="bi bi-chevron-down ms-2" style="color:#64748b; font-size:.75rem;"></i>
                </div>
                <div class="endpoint-body">
                    <h3>Example Request</h3>
                    <div class="code-block">
                        <button class="copy-btn" onclick="copyCode(this)">Copy</button>
                        curl -X DELETE {{ url('/api/v1/expenses/42') }} \
                        -H "Authorization: Bearer YOUR_TOKEN"
                    </div>
                    <h3>Response <span style="color:#4ade80; font-size:.75rem;">200 OK</span></h3>
                    <div class="code-block">
                        { <span class="key">"message"</span>: <span class="str">"Expense deleted
                            successfully."</span> }
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════════════
         BUDGET ENDPOINTS
    ════════════════════════════════════ --}}

        <section class="docs-section" id="budgets-list">
            <h2>🏷️ List Budgets</h2>
            <div class="endpoint-card">
                <div class="endpoint-header" onclick="toggle(this)">
                    <span class="endpoint-method method-GET">GET</span>
                    <span class="endpoint-path">/api/v1/budgets</span>
                    <span class="endpoint-desc">Get all budgets with progress</span>
                    <span class="endpoint-auth">🔒 Auth Required</span>
                    <i class="bi bi-chevron-down ms-2" style="color:#64748b; font-size:.75rem;"></i>
                </div>
                <div class="endpoint-body">
                    <h3>Response <span style="color:#4ade80; font-size:.75rem;">200 OK</span></h3>
                    <div class="code-block">
                        {
                        <span class="key">"data"</span>: [
                        {
                        <span class="key">"id"</span>: <span class="num">1</span>,
                        <span class="key">"category"</span>: <span class="str">"food"</span>,
                        <span class="key">"amount"</span>: <span class="num">5000.00</span>,
                        <span class="key">"spent"</span>: <span class="num">3200.00</span>,
                        <span class="key">"remaining"</span>: <span class="num">1800.00</span>,
                        <span class="key">"percent_used"</span>: <span class="num">64</span>,
                        <span class="key">"status"</span>: <span class="str">"success"</span>
                        }
                        ]
                        }
                    </div>
                </div>
            </div>
        </section>

        <section class="docs-section" id="budgets-create">
            <h2>➕ Create Budget</h2>
            <div class="endpoint-card">
                <div class="endpoint-header" onclick="toggle(this)">
                    <span class="endpoint-method method-POST">POST</span>
                    <span class="endpoint-path">/api/v1/budgets</span>
                    <span class="endpoint-desc">Set monthly budget limit</span>
                    <span class="endpoint-auth">🔒 Auth Required</span>
                    <i class="bi bi-chevron-down ms-2" style="color:#64748b; font-size:.75rem;"></i>
                </div>
                <div class="endpoint-body">
                    <div class="docs-alert info">
                        <i class="bi bi-info-circle-fill"></i>
                        <span>
                            If a budget for that category already exists,
                            it will be updated instead of creating a duplicate.
                        </span>
                    </div>
                    <h3>Request Body</h3>
                    <table class="params-table">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Type</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>category <span class="required-badge">required</span></td>
                                <td>string</td>
                                <td>food, travel, health, office, other</td>
                            </tr>
                            <tr>
                                <td>amount <span class="required-badge">required</span></td>
                                <td>numeric</td>
                                <td>Monthly limit (min: 0.01)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        {{-- Dashboard --}}
        <section class="docs-section" id="dashboard">
            <h2>📊 Dashboard Summary</h2>
            <div class="endpoint-card">
                <div class="endpoint-header" onclick="toggle(this)">
                    <span class="endpoint-method method-GET">GET</span>
                    <span class="endpoint-path">/api/v1/dashboard</span>
                    <span class="endpoint-desc">Financial summary & stats</span>
                    <span class="endpoint-auth">🔒 Auth Required</span>
                    <i class="bi bi-chevron-down ms-2" style="color:#64748b; font-size:.75rem;"></i>
                </div>
                <div class="endpoint-body">
                    <h3>Response <span style="color:#4ade80; font-size:.75rem;">200 OK</span></h3>
                    <div class="code-block">
                        {
                        <span class="key">"summary"</span>: {
                        <span class="key">"total_all_time"</span>: <span class="num">25430.50</span>,
                        <span class="key">"this_month"</span>: <span class="num">4200.00</span>,
                        <span class="key">"this_week"</span>: <span class="num">850.00</span>,
                        <span class="key">"total_expenses"</span>: <span class="num">47</span>
                        },
                        <span class="key">"by_category"</span>: [
                        { <span class="key">"category"</span>: <span class="str">"food"</span>, <span
                            class="key">"total"</span>: <span class="num">12000</span>, <span
                            class="key">"count"</span>: <span class="num">22</span> }
                        ],
                        <span class="key">"by_month"</span>: [
                        { <span class="key">"month"</span>: <span class="str">"2026-04"</span>, <span
                            class="key">"total"</span>: <span class="num">3800</span> },
                        { <span class="key">"month"</span>: <span class="str">"2026-05"</span>, <span
                            class="key">"total"</span>: <span class="num">4200</span> }
                        ]
                        }
                    </div>
                </div>
            </div>
        </section>

    </main>

    <script>
        // ── Toggle endpoint body ────────────────────
        function toggle(header) {
            const body = header.nextElementSibling;
            const icon = header.querySelector('.bi-chevron-down, .bi-chevron-up');
            body.classList.toggle('show');
            icon.classList.toggle('bi-chevron-down');
            icon.classList.toggle('bi-chevron-up');
        }

        // ── Copy code ───────────────────────────────
        function copyCode(btn) {
            const block = btn.parentElement;
            const text = block.innerText.replace('Copy', '').trim();
            navigator.clipboard.writeText(text).then(() => {
                btn.textContent = 'Copied!';
                btn.style.color = '#4ade80';
                setTimeout(() => {
                    btn.textContent = 'Copy';
                    btn.style.color = '';
                }, 2000);
            });
        }

        // ── Active nav on scroll ────────────────────
        const sections = document.querySelectorAll('.docs-section');
        const navLinks = document.querySelectorAll('.docs-nav-link');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                if (window.scrollY >= section.offsetTop - 80) {
                    current = section.id;
                }
            });
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        });
    </script>

</body>

</html>
