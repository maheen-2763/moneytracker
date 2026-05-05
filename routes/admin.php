<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {

    // ── Public ──────────────────────────
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // ── Protected ───────────────────────
    Route::middleware('admin')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Users
        Route::get('/users',            [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}',     [UserController::class, 'show'])->name('users.show');
        Route::post('/users/{user}/ban', [UserController::class, 'ban'])->name('users.ban');
        Route::delete('/users/{user}',  [UserController::class, 'destroy'])->name('users.destroy');

        // Expenses
        Route::get('/expenses',              [ExpenseController::class, 'index'])->name('expenses.index');
        Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
    });
});
