<?php

use App\Models\Budget;
use App\Models\User;
use App\Notifications\BudgetExceeded;
use Illuminate\Support\Facades\Notification;

test('budget exceeded notification fires when over limit', function () {
    Notification::fake();

    $user = User::factory()->create();
    $this->actingAs($user);

    Budget::factory()->create([
        'user_id'  => $user->id,
        'category' => 'food',
        'amount'   => 50,
    ]);

    $this->post(route('expenses.store'), [
        'title'        => 'Big meal',
        'amount'       => 60,
        'category'     => 'food',
        'expense_date' => now()->format('Y-m-d'),
    ]);

    Notification::assertSentTo($user, BudgetExceeded::class);
});

test('no notification fired when under budget', function () {
    Notification::fake();

    $user = User::factory()->create();
    $this->actingAs($user);

    Budget::factory()->create([
        'user_id'  => $user->id,
        'category' => 'food',
        'amount'   => 500,
    ]);

    $this->post(route('expenses.store'), [
        'title'        => 'Small snack',
        'amount'       => 10,
        'category'     => 'food',
        'expense_date' => now()->format('Y-m-d'),
    ]);

    Notification::assertNothingSent();
});

// tests/Feature/NotificationTest.php

test('no duplicate notification when already notified', function () {
    Notification::fake();

    $user = User::factory()->create();
    $this->actingAs($user);

    Budget::factory()->create([
        'user_id'  => $user->id,
        'category' => 'food',
        'amount'   => 50,
    ]);

    // First expense — triggers notification
    $this->post(route('expenses.store'), [
        'title'        => 'Lunch',
        'amount'       => 60,
        'category'     => 'food',
        'expense_date' => now()->format('Y-m-d'),
    ]);

    Notification::assertSentTo($user, BudgetExceeded::class);

    // ← Manually seed DB so duplicate guard works in tests
    // (Notification::fake() doesn't write to DB)
    $user->notifications()->create([
        'id'              => \Illuminate\Support\Str::uuid(),
        'type'            => BudgetExceeded::class,
        'notifiable_type' => User::class,
        'notifiable_id'   => $user->id,
        'data'            => [
            'type'     => 'budget_exceeded',
            'category' => 'food',
            'message'  => 'Food budget exceeded!',
        ],
        'read_at' => null,
    ]);

    // Second expense — should NOT trigger again
    $this->post(route('expenses.store'), [
        'title'        => 'Dinner',
        'amount'       => 20,
        'category'     => 'food',
        'expense_date' => now()->format('Y-m-d'),
    ]);

    // Still only 1 — second was blocked by guard
    Notification::assertSentToTimes($user, BudgetExceeded::class, 1);
});
