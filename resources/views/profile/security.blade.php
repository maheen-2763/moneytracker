@extends('layouts.app')
@section('title', 'Security Settings')

@section('content')

    <div class="page-heading">
        <h4>🔒 Security Settings</h4>
        <small>
            <a href="{{ route('profile.index') }}" class="text-muted">
                ← Back to profile
            </a>
        </small>
    </div>

    <div class="row g-4">

        {{-- ── Two Factor Auth Card ── --}}
        <div class="col-md-8">
            <div class="profile-info-card">
                <div class="info-card-header">
                    <i class="bi bi-shield-lock me-2"></i>
                    Two-Factor Authentication (2FA)
                    @if ($user->two_factor_enabled)
                        <span class="badge bg-success ms-2" style="font-size:.65rem;">Enabled ✅</span>
                    @else
                        <span class="badge bg-secondary ms-2" style="font-size:.65rem;">Disabled</span>
                    @endif
                </div>
                <div class="info-card-body">

                    @if ($user->two_factor_enabled)
                        {{-- ── Already enabled ── --}}
                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div style="font-size:2rem;">✅</div>
                            <div>
                                <div class="fw-bold mb-1">
                                    2FA is active on your account
                                </div>
                                <div class="text-muted" style="font-size:.85rem;">
                                    Your account is protected with two-factor
                                    authentication. You'll need your authenticator
                                    app every time you sign in.
                                </div>
                                <div class="text-muted mt-1" style="font-size:.78rem;">
                                    Enabled:
                                    {{ $user->two_factor_confirmed_at?->format('d M Y, h:i A') }}
                                </div>
                            </div>
                        </div>

                        {{-- Disable 2FA --}}
                        <div class="border border-danger rounded p-3" style="background:#fff5f5;">
                            <div class="fw-bold text-danger mb-1">
                                Disable Two-Factor Authentication
                            </div>
                            <div class="text-muted mb-3" style="font-size:.82rem;">
                                Enter your password to disable 2FA.
                                Your account will be less secure.
                            </div>
                            <form method="POST" action="{{ route('2fa.disable') }}">
                                @csrf
                                <div class="d-flex gap-2">
                                    <input type="password" name="password"
                                        class="form-control form-control-sm
                                              @error('password') is-invalid @enderror"
                                        placeholder="Enter your password" required>
                                    <button type="submit" class="btn btn-sm btn-danger px-3"
                                        onclick="return confirm('Disable 2FA?')">
                                        Disable
                                    </button>
                                </div>
                                @error('password')
                                    <div class="text-danger mt-1" style="font-size:.78rem;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </form>
                        </div>
                    @else
                        {{-- ── Setup 2FA ── --}}
                        <div class="row g-4">

                            {{-- Step 1: QR Code --}}
                            <div class="col-md-5 text-center">
                                <div class="fw-semibold mb-2" style="font-size:.85rem;">
                                    Step 1: Scan QR Code
                                </div>
                                <div class="border rounded p-3 d-inline-block bg-white">
                                    <img src="data:image/svg+xml;base64,{{ $qrCodeSvg }}" width="160" height="160"
                                        alt="QR Code">
                                </div>
                                <div class="text-muted mt-2" style="font-size:.75rem;">
                                    Use Google Authenticator,<br>
                                    Authy, or any TOTP app
                                </div>
                            </div>

                            {{-- Step 2: Manual key + verify --}}
                            <div class="col-md-7">
                                <div class="fw-semibold mb-2" style="font-size:.85rem;">
                                    Step 2: Manual Key (if QR fails)
                                </div>
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <code class="p-2 rounded"
                                        style="background:#f1f5f9;
                                             font-size:.78rem;
                                             letter-spacing:.1em;
                                             word-break:break-all;">
                                        {{ $secret }}
                                    </code>
                                    <button onclick="copySecret('{{ $secret }}')"
                                        class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-copy"></i>
                                    </button>
                                </div>

                                <div class="fw-semibold mb-2" style="font-size:.85rem;">
                                    Step 3: Enter 6-digit Code
                                </div>
                                <form method="POST" action="{{ route('2fa.enable') }}">
                                    @csrf
                                    <div class="d-flex gap-2 mb-2">
                                        <input type="text" name="otp"
                                            class="form-control
                                                  @error('otp') is-invalid @enderror"
                                            placeholder="Enter 6-digit code" maxlength="6" inputmode="numeric"
                                            pattern="[0-9]{6}" autocomplete="off" required>
                                        <button type="submit" class="btn btn-primary px-4">
                                            Enable
                                        </button>
                                    </div>
                                    @error('otp')
                                        <div class="text-danger" style="font-size:.78rem;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </form>

                                <div class="mt-3 p-3 rounded" style="background:#f0fdf4; border:1px solid #bbf7d0;">
                                    <div class="fw-bold text-success mb-1" style="font-size:.82rem;">
                                        <i class="bi bi-shield-check me-1"></i>
                                        What 2FA protects you from:
                                    </div>
                                    <ul class="text-muted mb-0" style="font-size:.78rem; padding-left:1rem;">
                                        <li>Password theft</li>
                                        <li>Phishing attacks</li>
                                        <li>Unauthorized access</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── Security Tips ── --}}
        <div class="col-md-4">
            <div class="profile-info-card">
                <div class="info-card-header">
                    <i class="bi bi-lightbulb me-2"></i>Security Tips
                </div>
                <div class="info-card-body">
                    <div class="d-flex flex-column gap-3">

                        <div class="d-flex gap-2 align-items-start">
                            <span style="font-size:1.1rem;">🔑</span>
                            <div>
                                <div class="fw-semibold" style="font-size:.82rem;">
                                    Strong Password
                                </div>
                                <div class="text-muted" style="font-size:.75rem;">
                                    Use 12+ chars with mixed case,
                                    numbers and symbols
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 align-items-start">
                            <span style="font-size:1.1rem;">📱</span>
                            <div>
                                <div class="fw-semibold" style="font-size:.82rem;">
                                    Enable 2FA
                                </div>
                                <div class="text-muted" style="font-size:.75rem;">
                                    Adds a second layer of protection
                                    even if password is stolen
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 align-items-start">
                            <span style="font-size:1.1rem;">🚫</span>
                            <div>
                                <div class="fw-semibold" style="font-size:.82rem;">
                                    Don't Reuse Passwords
                                </div>
                                <div class="text-muted" style="font-size:.75rem;">
                                    Use a password manager like
                                    Bitwarden or 1Password
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 align-items-start">
                            <span style="font-size:1.1rem;">👁️</span>
                            <div>
                                <div class="fw-semibold" style="font-size:.82rem;">
                                    Review Active Sessions
                                </div>
                                <div class="text-muted" style="font-size:.75rem;">
                                    Sign out from devices you
                                    no longer use
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 align-items-start">
                            <span style="font-size:1.1rem;">🔔</span>
                            <div>
                                <div class="fw-semibold" style="font-size:.82rem;">
                                    Keep Email Updated
                                </div>
                                <div class="text-muted" style="font-size:.75rem;">
                                    Needed for password reset
                                    and notifications
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Quick actions --}}
                    <div class="mt-4 d-grid gap-2">
                        <a href="{{ route('profile.edit') }}#password" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-lock me-1"></i>Change Password
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            function copySecret(secret) {
                navigator.clipboard.writeText(secret).then(() => {
                    alert('Secret key copied!');
                });
            }
        </script>
    @endpush

@endsection
