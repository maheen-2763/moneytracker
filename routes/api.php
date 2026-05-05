<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BudgetController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ExpenseController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {  // ← add name prefix

    // Public
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('throttle:5,1');

    // Protected
    Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
        Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');
        Route::get('/me',        [AuthController::class, 'me'])->name('me');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::apiResource('expenses', ExpenseController::class);
        Route::apiResource('budgets',  BudgetController::class)
            ->only(['index', 'store', 'update', 'destroy']);
    });
});
