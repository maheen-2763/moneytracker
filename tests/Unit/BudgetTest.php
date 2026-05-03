<?php

use App\Models\Budget;
use App\Models\Expense;
use App\Models\User;

test('calculates spent this month correctly', function () {
    $user = User::factory()->create();   // ← create inside each test

    $budget = Budget::factory()->create([
        'user_id'  => $user->id,
        'category' => 'food',
        'amount'   => 100,
    ]);

    Expense::factory()->create([
        'user_id'      => $user->id,
        'category'     => 'food',
        'amount'       => 40,
        'expense_date' => now(),
    ]);

    // Last month — should NOT count
    Expense::factory()->create([
        'user_id'      => $user->id,
        'category'     => 'food',
        'amount'       => 999,
        'expense_date' => now()->subMonth(),
    ]);

    expect($budget->spentThisMonth())->toBe(40.0);
});

test('percent used is calculated correctly', function () {
    $user = User::factory()->create();

    $budget = Budget::factory()->create([
        'user_id'  => $user->id,
        'category' => 'food',
        'amount'   => 100,
    ]);

    Expense::factory()->create([
        'user_id'      => $user->id,
        'category'     => 'food',
        'amount'       => 75,
        'expense_date' => now(),
    ]);

    expect($budget->percentUsed())->toBe(75);
});

test('percent used is capped at 100', function () {
    $user = User::factory()->create();

    $budget = Budget::factory()->create([
        'user_id'  => $user->id,
        'category' => 'food',
        'amount'   => 50,
    ]);

    Expense::factory()->create([
        'user_id'      => $user->id,
        'category'     => 'food',
        'amount'       => 200,
        'expense_date' => now(),
    ]);

    expect($budget->percentUsed())->toBe(100);
});

test('status returns correct value', function () {
    $user = User::factory()->create();

    $budget = Budget::factory()->create([
        'user_id'  => $user->id,
        'category' => 'food',
        'amount'   => 100,
    ]);

    // 50% → success
    Expense::factory()->create([
        'user_id'      => $user->id,
        'category'     => 'food',
        'amount'       => 50,
        'expense_date' => now(),
    ]);
    expect($budget->status())->toBe('success');

    // +35% = 85% → warning
    Expense::factory()->create([
        'user_id'      => $user->id,
        'category'     => 'food',
        'amount'       => 35,
        'expense_date' => now(),
    ]);
    expect($budget->status())->toBe('warning');

    // +20% = 105% → danger
    Expense::factory()->create([
        'user_id'      => $user->id,
        'category'     => 'food',
        'amount'       => 20,
        'expense_date' => now(),
    ]);
    expect($budget->status())->toBe('danger');
});

test('only counts expenses for matching category', function () {
    $user = User::factory()->create();

    $budget = Budget::factory()->create([
        'user_id'  => $user->id,
        'category' => 'food',
        'amount'   => 100,
    ]);

    Expense::factory()->create([
        'user_id'      => $user->id,
        'category'     => 'food',
        'amount'       => 50,
        'expense_date' => now(),
    ]);

    // Different category — must NOT count
    Expense::factory()->create([
        'user_id'      => $user->id,
        'category'     => 'travel',
        'amount'       => 999,
        'expense_date' => now(),
    ]);

    expect($budget->spentThisMonth())->toBe(50.0);
});
