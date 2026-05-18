<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoneyTracker — Verify Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-[Plus_Jakarta_Sans] bg-gray-50 dark:bg-gray-950
             min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-md">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <x-app-logo size="lg" :dark="false" />
        </div>

        {{-- Card --}}
        <div
            class="rounded-2xl border border-gray-200 dark:border-gray-800
                    bg-white dark:bg-gray-900 shadow-sm overflow-hidden">

            {{-- Header --}}
            <div class="px-8 pt-8 pb-6 border-b border-gray-200 dark:border-gray-800">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl
                                bg-indigo-100 dark:bg-indigo-900/30
                                flex items-center justify-center shrink-0">
                        <i class="bi bi-envelope-check text-indigo-500 text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                            Verify your email
                        </h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                            Check your inbox for a verification link
                        </p>
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="px-8 py-6 space-y-5">

                {{-- Info --}}
                <div
                    class="flex items-start gap-3 px-4 py-3 rounded-xl
                            bg-indigo-50 dark:bg-indigo-900/20
                            border border-indigo-200 dark:border-indigo-900/40
                            text-indigo-700 dark:text-indigo-400 text-sm">
                    <i class="bi bi-info-circle-fill shrink-0 mt-0.5"></i>
                    <p>
                        Thanks for signing up! Before getting started, please verify
                        your email address by clicking the link we sent you.
                    </p>
                </div>

                {{-- Success --}}
                @if (session('status') == 'verification-link-sent')
                    <div
                        class="flex items-center gap-2 px-4 py-3 rounded-xl
                                bg-green-50 dark:bg-green-900/20
                                border border-green-200 dark:border-green-900/40
                                text-green-700 dark:text-green-400 text-sm">
                        <i class="bi bi-check-circle-fill shrink-0"></i>
                        A new verification link has been sent to your email address.
                    </div>
                @endif

                {{-- Resend Button --}}
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="w-full py-2.5 rounded-xl
                               bg-indigo-500 hover:bg-indigo-600
                               text-white text-sm font-bold
                               hover:-translate-y-0.5 transition-all duration-200">
                        <i class="bi bi-envelope mr-2"></i>
                        Resend Verification Email
                    </button>
                </form>

            </div>

            {{-- Footer --}}
            <div
                class="px-8 py-4 border-t border-gray-200 dark:border-gray-800
                        bg-gray-50 dark:bg-gray-800/50 flex items-center justify-between">
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Wrong account?
                </p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-600 transition">
                        <i class="bi bi-box-arrow-right mr-1"></i>
                        Log Out
                    </button>
                </form>
            </div>

        </div>

    </div>

</body>

</html>
