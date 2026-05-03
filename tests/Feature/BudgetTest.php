<?php

use App\Models\Budget;
use App\Models\User;


beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('budgets page loads', function () {
    $this->get(route('budgets.index'))
        ->assertOk()
        ->assertSee('Budget Limits');
});

test('user can create a budget', function () {
    // ← use $this->user not a new user
    $this->post(route('budgets.store'), [
        'category' => 'food',
        'amount'   => 500,
    ])->assertRedirect();

    $this->assertDatabaseHas('budgets', [
        'user_id'  => $this->user->id,  // ← matches actingAs user
        'category' => 'food',
        'amount'   => 500,
    ]);
});

test('user can update a budget', function () {
    $budget = Budget::factory()->create([
        'user_id'  => $this->user->id,
        'category' => 'food',
        'amount'   => 500,
    ]);

    $this->put(route('budgets.update', $budget), [
        'amount' => 1000,
    ])->assertRedirect();

    $this->assertDatabaseHas('budgets', [
        'id'     => $budget->id,
        'amount' => 1000,
    ]);
});

test('user can delete a budget', function () {
    $budget = Budget::factory()->create([
        'user_id' => $this->user->id,
    ]);

    $this->delete(route('budgets.destroy', $budget))
        ->assertRedirect();

    $this->assertDatabaseMissing('budgets', ['id' => $budget->id]);
});

test('user cannot delete another users budget', function () {
    $otherUser   = User::factory()->create();
    $theirBudget = Budget::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    $this->delete(route('budgets.destroy', $theirBudget))
        ->assertForbidden();
});

test('budget amount must be positive', function () {
    $this->post(route('budgets.store'), [
        'category' => 'food',
        'amount'   => -100,
    ])->assertSessionHasErrors('amount');
});
