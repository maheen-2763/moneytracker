@extends('layouts.app')
@section('title', 'Security Settings')

@section('content')

    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                    Security Settings
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                    Manage your account security and privacy
                </p>
            </div>
            <a href="{{ route('profile.index') }}"
                class="text-sm font-medium text-indigo-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                ← Back to Profile
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ── Two Factor Auth Card ── --}}
            <div class="lg:col-span-2">
                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                        bg-white dark:bg-gray-900 shadow-sm overflow-hidden">
                    <div
                        class="flex items-center gap-2 px-6 py-4
                        border-b border-gray-200 dark:border-gray-800">
                        <i class="bi bi-shield-lock text-indigo-500"></i>
                        <h2 class="text-sm font-bold text-gray-900 dark:text-white flex-1">
                            Two-Factor Authentication (2FA)
                        </h2>
                        @if ($user->two_factor_enabled)
                            <span
                                class="px-2.5 py-0.5 rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200 text-xs font-semibold">Enabled
                                ✅</span>
                        @else
                            <span
                                class="px-2.5 py-0.5 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-xs font-semibold">Disabled</span>
                        @endif
                    </div>
                    <div class="p-6 space-y-6">

                        @if ($user->two_factor_enabled)
                            {{-- ── Already enabled ── --}}
                            <div class="flex gap-4">
                                <div class="text-3xl flex-shrink-0">✅</div>
                                <div>
                                    <div class="font-semibold text-gray-900 dark:text-white mb-1">
                                        2FA is active on your account
                                    </div>
                                    <div class="text-gray-600 dark:text-gray-400 text-sm mb-2">
                                        Your account is protected with two-factor
                                        authentication. You'll need your authenticator
                                        app every time you sign in.
                                    </div>
                                    <div class="text-gray-500 dark:text-gray-500 text-xs">
                                        Enabled:
                                        {{ $user->two_factor_confirmed_at?->format('d M Y, h:i A') }}
                                    </div>
                                </div>
                            </div>

                            {{-- Disable 2FA --}}
                            <div
                                class="border border-red-200 dark:border-red-900/40 rounded-xl p-4 bg-red-50 dark:bg-red-900/20">
                                <div class="font-semibold text-red-900 dark:text-red-200 mb-1">
                                    Disable Two-Factor Authentication
                                </div>
                                <div class="text-gray-700 dark:text-gray-300 text-sm mb-4">
                                    Enter your password to disable 2FA.
                                    Your account will be less secure.
                                </div>
                                <form method="POST" action="{{ route('2fa.disable') }}">
                                    @csrf
                                    <div class="flex gap-2">
                                        <input type="password" name="password"
                                            class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-gray-700
                                              rounded-xl text-sm placeholder-gray-400 dark:placeholder-gray-500
                                              bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                                              focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-500
                                              @error('password') ring-2 ring-red-500 border-red-500 @enderror
                                              transition"
                                            placeholder="Enter your password" required>
                                        <button type="submit"
                                            class="px-5 py-2.5 bg-red-500 hover:bg-red-600 dark:hover:bg-red-600 text-white text-sm font-semibold rounded-xl transition"
                                            onclick="return confirm('Disable 2FA?')">
                                            Disable
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="text-red-600 dark:text-red-400 text-xs mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </form>
                            </div>
                        @else
                            {{-- ── Setup 2FA ── --}}
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-6">

                                {{-- Step 1: QR Code --}}
                                <div class="md:col-span-2 flex flex-col items-center">
                                    <div class="font-semibold text-sm text-gray-900 dark:text-white mb-3">
                                        Step 1: Scan QR Code
                                    </div>
                                    <div
                                        class="border border-gray-200 dark:border-gray-700 rounded-xl p-4 bg-white dark:bg-gray-800 inline-block">
                                        <img src="data:image/svg+xml;base64,{{ $qrCodeSvg }}" width="160"
                                            height="160" alt="QR Code">
                                    </div>
                                    <div class="text-gray-600 dark:text-gray-400 text-xs mt-3 text-center">
                                        Use Google Authenticator,<br>
                                        Authy, or any TOTP app
                                    </div>
                                </div>

                                {{-- Step 2: Manual key + verify --}}
                                <div class="md:col-span-3 space-y-4">
                                    <div>
                                        <div class="font-semibold text-sm text-gray-900 dark:text-white mb-3">
                                            Step 2: Manual Key (if QR fails)
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <code
                                                class="flex-1 px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-gray-800 text-xs font-mono tracking-widest break-all
                                                    text-gray-900 dark:text-white border border-gray-200 dark:border-gray-700">
                                                {{ $secret }}
                                            </code>
                                            <button onclick="copySecret('{{ $secret }}')"
                                                class="px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 transition"
                                                title="Copy secret key">
                                                <i class="bi bi-copy"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="font-semibold text-sm text-gray-900 dark:text-white mb-3">
                                            Step 3: Enter 6-digit Code
                                        </div>
                                        <form method="POST" action="{{ route('2fa.enable') }}">
                                            @csrf
                                            <div class="flex gap-2 mb-3">
                                                <input type="text" name="otp"
                                                    class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-gray-700
                                                       rounded-xl text-sm placeholder-gray-400 dark:placeholder-gray-500
                                                       bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                                                       focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500
                                                       @error('otp') ring-2 ring-red-500 border-red-500 @enderror
                                                       transition"
                                                    placeholder="Enter 6-digit code" maxlength="6" inputmode="numeric"
                                                    pattern="[0-9]{6}" autocomplete="off" required>
                                                <button type="submit"
                                                    class="px-6 py-2.5 bg-blue-500 hover:bg-blue-600 dark:hover:bg-blue-600 text-white text-sm font-semibold rounded-xl transition">
                                                    Enable
                                                </button>
                                            </div>
                                            @error('otp')
                                                <div class="text-red-600 dark:text-red-400 text-xs">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </form>
                                    </div>

                                    <div
                                        class="p-4 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-900/40">
                                        <div
                                            class="font-semibold text-green-900 dark:text-green-200 mb-2 text-sm flex items-center gap-1">
                                            <i class="bi bi-shield-check"></i>
                                            What 2FA protects you from:
                                        </div>
                                        <ul class="text-gray-700 dark:text-gray-300 text-xs space-y-1 ml-4">
                                            <li>• Password theft</li>
                                            <li>• Phishing attacks</li>
                                            <li>• Unauthorized access</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ── Security Tips ── --}}
            <div class="lg:col-span-1">
                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-800
                    bg-white dark:bg-gray-900 shadow-sm overflow-hidden">
                    <div
                        class="flex items-center gap-2 px-6 py-4
                    border-b border-gray-200 dark:border-gray-800">
                        <i class="bi bi-lightbulb text-indigo-500"></i>
                        <span class="font-bold text-sm text-gray-900 dark:text-white">Security Tips</span>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">

                            <div class="flex gap-3">
                                <span class="text-xl flex-shrink-0">🔑</span>
                                <div>
                                    <div class="font-semibold text-sm text-gray-900 dark:text-white">
                                        Strong Password
                                    </div>
                                    <div class="text-gray-600 dark:text-gray-400 text-xs mt-0.5">
                                        Use 12+ chars with mixed case,
                                        numbers and symbols
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <span class="text-xl flex-shrink-0">📱</span>
                                <div>
                                    <div class="font-semibold text-sm text-gray-900 dark:text-white">
                                        Enable 2FA
                                    </div>
                                    <div class="text-gray-600 dark:text-gray-400 text-xs mt-0.5">
                                        Adds a second layer of protection
                                        even if password is stolen
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <span class="text-xl flex-shrink-0">🚫</span>
                                <div>
                                    <div class="font-semibold text-sm text-gray-900 dark:text-white">
                                        Don't Reuse Passwords
                                    </div>
                                    <div class="text-gray-600 dark:text-gray-400 text-xs mt-0.5">
                                        Use a password manager like
                                        Bitwarden or 1Password
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <span class="text-xl flex-shrink-0">👁️</span>
                                <div>
                                    <div class="font-semibold text-sm text-gray-900 dark:text-white">
                                        Review Active Sessions
                                    </div>
                                    <div class="text-gray-600 dark:text-gray-400 text-xs mt-0.5">
                                        Sign out from devices you
                                        no longer use
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <span class="text-xl flex-shrink-0">🔔</span>
                                <div>
                                    <div class="font-semibold text-sm text-gray-900 dark:text-white">
                                        Keep Email Updated
                                    </div>
                                    <div class="text-gray-600 dark:text-gray-400 text-xs mt-0.5">
                                        Needed for password reset
                                        and notifications
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- Quick actions --}}
                        <div class="mt-6">
                            <a href="{{ route('profile.edit') }}#password"
                                class="w-full block px-4 py-2.5 border border-indigo-300 dark:border-indigo-900/40 text-indigo-500 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 text-sm font-semibold rounded-xl transition text-center">
                                <i class="bi bi-lock me-1"></i>Change Password
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection

    @push('scripts')
        <script>
            function copySecret(secret) {
                navigator.clipboard.writeText(secret).then(() => {
                    alert('Secret key copied!');
                });
            }
        </script>
    @endpush
