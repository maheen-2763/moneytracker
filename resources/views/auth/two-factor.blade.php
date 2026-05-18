<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoneyTracker — Two Factor Authentication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=JetBrains+Mono:wght@500&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .otp-input {
            width: 48px;
            height: 56px;
            background: #0f172a;
            border: 2px solid #334155;
            border-radius: 12px;
            color: #fff;
            font-size: 1.4rem;
            font-weight: 700;
            font-family: 'JetBrains Mono', monospace;
            text-align: center;
            transition: border-color 0.2s;
        }

        .otp-input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .otp-input.filled {
            border-color: #6366f1;
        }
    </style>
</head>

<body class="bg-gray-950 min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-sm">

        {{-- Card --}}
        <div class="rounded-2xl border border-gray-800
                    bg-gray-900 shadow-2xl overflow-hidden">

            {{-- Header --}}
            <div class="px-8 pt-8 pb-6 text-center
                        border-b border-gray-800">

                {{-- Icon --}}
                <div
                    class="w-16 h-16 rounded-2xl mx-auto mb-4
                            bg-gradient-to-br from-indigo-500 to-violet-500
                            flex items-center justify-center
                            shadow-lg shadow-indigo-500/20 text-3xl">
                    🔐
                </div>

                <h1 class="text-xl font-extrabold text-white tracking-tight">
                    Two-Factor Auth
                </h1>
                <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">
                    Enter the 6-digit code from your<br>
                    authenticator app to continue.
                </p>
            </div>

            {{-- Body --}}
            <div class="px-8 py-6">

                {{-- Error --}}
                @if ($errors->any())
                    <div
                        class="mb-5 flex items-center gap-2 px-4 py-3 rounded-xl
                                bg-red-500/10 border border-red-500/20
                                text-red-400 text-sm">
                        <i class="bi bi-exclamation-circle shrink-0"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('2fa.verify') }}" id="otpForm">
                    @csrf

                    {{-- Hidden OTP input --}}
                    <input type="hidden" name="otp" id="otpValue">

                    {{-- OTP Boxes --}}
                    <div class="flex items-center justify-center gap-2 mb-6">
                        @for ($i = 0; $i < 6; $i++)
                            <input type="text" class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]"
                                autocomplete="off">
                        @endfor
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full py-2.5 rounded-xl
                               bg-indigo-500 hover:bg-indigo-600
                               text-white text-sm font-bold
                               flex items-center justify-center gap-2
                               hover:-translate-y-0.5 transition-all duration-200
                               shadow-lg shadow-indigo-500/20">
                        <i class="bi bi-shield-check"></i>
                        Verify Code
                    </button>

                </form>

            </div>

            {{-- Footer --}}
            <div
                class="px-8 py-4 border-t border-gray-800
                        bg-gray-900/50 flex items-center justify-between">
                <p class="text-xs text-gray-600">Not you?</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="text-xs font-semibold text-red-400
                               hover:text-red-300 transition">
                        <i class="bi bi-box-arrow-right mr-1"></i>
                        Sign out
                    </button>
                </form>
            </div>

        </div>

        {{-- Bottom note --}}
        <p class="text-center text-xs text-gray-700 mt-6">
            <i class="bi bi-shield-lock-fill mr-1"></i>
            Protected by Two-Factor Authentication
        </p>

    </div>

    <script>
        const inputs = document.querySelectorAll('.otp-input');
        const hidden = document.getElementById('otpValue');
        const form = document.getElementById('otpForm');

        inputs[0].focus();

        inputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                input.value = input.value.replace(/[^0-9]/g, '');

                if (input.value) {
                    input.classList.add('filled');
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                } else {
                    input.classList.remove('filled');
                }

                hidden.value = [...inputs].map(i => i.value).join('');

                if (hidden.value.length === 6) {
                    setTimeout(() => form.submit(), 200);
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && index > 0) {
                    inputs[index - 1].focus();
                    inputs[index - 1].value = '';
                    inputs[index - 1].classList.remove('filled');
                }
            });

            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pasted = e.clipboardData.getData('text').replace(/[^0-9]/g, '');
                [...pasted].forEach((char, i) => {
                    if (inputs[i]) {
                        inputs[i].value = char;
                        inputs[i].classList.add('filled');
                    }
                });
                hidden.value = pasted.substring(0, 6);
                if (hidden.value.length === 6) {
                    setTimeout(() => form.submit(), 200);
                }
            });
        });
    </script>

</body>

</html>
