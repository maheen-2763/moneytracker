<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TwoFactorController;
use Illuminate\Support\Facades\Auth;

// Landing page - accessible to everyone
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Public API docs page — no auth needed
Route::get('/api/docs', function () {
    return view('api.docs');
})->name('api.docs');

// Protected routes - authenticated users only
Route::middleware(['auth', 'verified', 'throttle:60,1'])->group(function () {

    // 2FA challenge (shown after login if 2FA enabled)
    Route::get('/2fa/challenge',  [TwoFactorController::class, 'challenge'])->name('2fa.challenge');
    Route::post('/2fa/verify',    [TwoFactorController::class, 'verify'])->name('2fa.verify');

    // 2FA management (in profile)
    Route::get('/profile/security',  [TwoFactorController::class, 'setup'])->name('profile.security');
    Route::post('/2fa/enable',       [TwoFactorController::class, 'enable'])->name('2fa.enable');
    Route::post('/2fa/disable',      [TwoFactorController::class, 'disable'])->name('2fa.disable');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Profile routes
    Route::get('/profile',              [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit',         [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',              [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password',     [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile/avatar',    [ProfileController::class, 'removeAvatar'])->name('profile.avatar.remove');

    // Export routes
    Route::get('/expenses/export/excel', [ExportController::class, 'excel'])->name('expenses.export.excel');
    Route::get('/expenses/export/pdf',   [ExportController::class, 'pdf'])->name('expenses.export.pdf');

    // Budget routes
    Route::resource('budgets', BudgetController::class)
        ->only(['index', 'store', 'update', 'destroy']);

    // Expense routes
    Route::resource('expenses', ExpenseController::class);

    // Notification routes
    Route::get('/notifications',              [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}/read',    [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::get('/notifications/read-all',     [NotificationController::class, 'markAllRead'])->name('notifications.read-all');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // After logout, clear 2FA session
    Route::post('/logout', function () {
        session()->forget('2fa_verified');
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});

// Auth routes (login, register, etc.)
require __DIR__ . '/auth.php';
