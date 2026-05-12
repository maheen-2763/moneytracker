<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Page Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-[Plus_Jakarta_Sans] bg-gray-50 dark:bg-gray-950
             min-h-screen flex items-center justify-center p-6">

    <div class="text-center max-w-md mx-auto">

        {{-- Error Code --}}
        <p class="text-8xl font-extrabold text-indigo-500 tracking-tight">
            404
        </p>

        {{-- Icon --}}
        <div
            class="w-20 h-20 rounded-2xl mx-auto my-6
                    bg-indigo-100 dark:bg-indigo-900/30
                    flex items-center justify-center">
            <i class="bi bi-map text-indigo-500 text-4xl"></i>
        </div>

        {{-- Message --}}
        <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">
            Page Not Found
        </h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 mb-8">
            Oops! The page you're looking for doesn't exist or has been moved.
        </p>

        {{-- Actions --}}
        <div class="flex items-center justify-center gap-3 flex-wrap">
            <a href="{{ url('/') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl
                       bg-indigo-500 hover:bg-indigo-600
                       text-white text-sm font-semibold transition
                       hover:-translate-y-0.5 duration-200">
                <i class="bi bi-house"></i>
                Go Home
            </a>
            <button onclick="history.back()"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl
                       border border-gray-200 dark:border-gray-700
                       text-gray-700 dark:text-gray-300 text-sm font-semibold
                       hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                <i class="bi bi-arrow-left"></i>
                Go Back
            </button>
        </div>

    </div>

</body>

</html>
