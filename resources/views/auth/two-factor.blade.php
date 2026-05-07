<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoneyTracker — Two Factor Authentication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=JetBrains+Mono:wght@500&display=swap"
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

        .tfa-card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 20px;
            padding: 2.5rem;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .tfa-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin: 0 auto 1.5rem;
        }

        .tfa-title {
            font-size: 1.3rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.03em;
            margin-bottom: 0.4rem;
        }

        .tfa-sub {
            color: #64748b;
            font-size: 0.85rem;
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        /* OTP Input */
        .otp-inputs {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            margin-bottom: 1.5rem;
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

        .btn-verify {
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .btn-verify:hover {
            opacity: 0.9;
        }

        .error-msg {
            background: #450a0a;
            border: 1px solid #7f1d1d;
            color: #fca5a5;
            border-radius: 8px;
            padding: 0.65rem 1rem;
            font-size: 0.82rem;
            margin-bottom: 1rem;
        }

        .logout-link {
            margin-top: 1rem;
            font-size: 0.78rem;
            color: #475569;
        }

        .logout-link a {
            color: #6366f1;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="tfa-card">
        <div class="tfa-icon">🔐</div>
        <div class="tfa-title">Two-Factor Auth</div>
        <div class="tfa-sub">
            Enter the 6-digit code from your<br>
            authenticator app to continue.
        </div>

        @if ($errors->any())
            <div class="error-msg">
                <i class="bi bi-exclamation-circle me-1"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('2fa.verify') }}" id="otpForm">
            @csrf

            {{-- Hidden input that gets filled by JS --}}
            <input type="hidden" name="otp" id="otpValue">

            {{-- Visual OTP boxes --}}
            <div class="otp-inputs">
                @for ($i = 0; $i < 6; $i++)
                    <input type="text" class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]"
                        autocomplete="off">
                @endfor
            </div>

            <button type="submit" class="btn-verify">
                <i class="bi bi-shield-check me-2"></i>Verify Code
            </button>
        </form>

        <div class="logout-link">
            Not you?
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit"
                    style="background:none; border:none; padding:0;
                           color:#6366f1; cursor:pointer; font-size:.78rem;">
                    Sign out
                </button>
            </form>
        </div>
    </div>

    <script>
        const inputs = document.querySelectorAll('.otp-input');
        const hidden = document.getElementById('otpValue');
        const form = document.getElementById('otpForm');

        // Focus first input
        inputs[0].focus();

        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                // Only allow digits
                input.value = input.value.replace(/[^0-9]/g, '');

                if (input.value) {
                    input.classList.add('filled');
                    // Move to next
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                } else {
                    input.classList.remove('filled');
                }

                // Update hidden input
                hidden.value = [...inputs].map(i => i.value).join('');

                // Auto-submit when all 6 filled
                if (hidden.value.length === 6) {
                    setTimeout(() => form.submit(), 200);
                }
            });

            // Handle backspace
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && index > 0) {
                    inputs[index - 1].focus();
                    inputs[index - 1].value = '';
                    inputs[index - 1].classList.remove('filled');
                }
            });

            // Handle paste
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
