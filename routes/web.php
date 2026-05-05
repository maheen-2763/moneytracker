<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\NotificationController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified', 'throttle:60,1'])->group(function () {
    Route::get('/profile',              [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit',         [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',              [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password',     [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile/avatar',    [ProfileController::class, 'removeAvatar'])->name('profile.avatar.remove');

    Route::get('/expenses/export/excel', [ExportController::class, 'excel'])->name('expenses.export.excel');
    Route::get('/expenses/export/pdf',   [ExportController::class, 'pdf'])->name('expenses.export.pdf');

    Route::resource('budgets', BudgetController::class)
        ->only(['index', 'store', 'update', 'destroy']);

    // Notifications
    Route::get('/notifications',              [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}/read',    [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::get('/notifications/read-all',     [NotificationController::class, 'markAllRead'])->name('notifications.read-all');

    Route::resource('expenses', ExpenseController::class);

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});

require __DIR__ . '/auth.php';
