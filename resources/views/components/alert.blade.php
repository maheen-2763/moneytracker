@if (session('success'))
    <div class="flex items-center gap-3 px-4 py-3 mb-6 rounded-xl
                bg-green-50 dark:bg-green-900/20
                border border-green-200 dark:border-green-900/40
                text-green-700 dark:text-green-400 text-sm"
        id="alert-success">
        <i class="bi bi-check-circle-fill shrink-0"></i>
        <p class="flex-1 font-medium">{{ session('success') }}</p>
        <button onclick="document.getElementById('alert-success').remove()"
            class="text-green-500 hover:text-green-700 dark:hover:text-green-300 transition">
            <i class="bi bi-x-lg text-xs"></i>
        </button>
    </div>
@endif

@if (session('error'))
    <div class="flex items-center gap-3 px-4 py-3 mb-6 rounded-xl
                bg-red-50 dark:bg-red-900/20
                border border-red-200 dark:border-red-900/40
                text-red-700 dark:text-red-400 text-sm"
        id="alert-error">
        <i class="bi bi-exclamation-circle-fill shrink-0"></i>
        <p class="flex-1 font-medium">{{ session('error') }}</p>
        <button onclick="document.getElementById('alert-error').remove()"
            class="text-red-500 hover:text-red-700 dark:hover:text-red-300 transition">
            <i class="bi bi-x-lg text-xs"></i>
        </button>
    </div>
@endif

@if (session('warning'))
    <div class="flex items-center gap-3 px-4 py-3 mb-6 rounded-xl
                bg-yellow-50 dark:bg-yellow-900/20
                border border-yellow-200 dark:border-yellow-900/40
                text-yellow-700 dark:text-yellow-400 text-sm"
        id="alert-warning">
        <i class="bi bi-exclamation-triangle-fill shrink-0"></i>
        <p class="flex-1 font-medium">{{ session('warning') }}</p>
        <button onclick="document.getElementById('alert-warning').remove()"
            class="text-yellow-500 hover:text-yellow-700 dark:hover:text-yellow-300 transition">
            <i class="bi bi-x-lg text-xs"></i>
        </button>
    </div>
@endif
