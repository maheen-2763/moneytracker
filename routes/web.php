<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExpenseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ReportController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile',              [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit',         [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',              [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password',     [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile/avatar',    [ProfileController::class, 'removeAvatar'])->name('profile.avatar.remove');

    Route::get('/expenses/export/excel', [ExportController::class, 'excel'])->name('expenses.export.excel');
    Route::get('/expenses/export/pdf',   [ExportController::class, 'pdf'])->name('expenses.export.pdf');

    Route::resource('expenses', ExpenseController::class);

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});

require __DIR__ . '/auth.php';
