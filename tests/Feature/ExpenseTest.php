<?php


use App\Models\Expense;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('expenses page loads', function () {
    $this->get(route('expenses.index'))
        ->assertOk();
});

test('user can create an expense', function () {
    $this->post(route('expenses.store'), [
        'title'        => 'Team Lunch',
        'amount'       => 45.50,
        'category'     => 'food',
        'expense_date' => now()->format('Y-m-d'),
        'description'   => 'Office lunch',
    ])->assertRedirect(route('expenses.index'));

    $this->assertDatabaseHas('expenses', [
        'title'   => 'Team Lunch',
        'user_id' => $this->user->id,
    ]);
});

test('user can update an expense', function () {
    $expense = Expense::factory()->create([
        'user_id' => $this->user->id,
    ]);

    $this->put(route('expenses.update', $expense), [
        'title'        => 'Updated Title',
        'amount'       => 99.99,
        'category'     => 'travel',
        'expense_date' => now()->format('Y-m-d'),
    ])->assertRedirect(route('expenses.index'));

    $this->assertDatabaseHas('expenses', [
        'id'    => $expense->id,
        'title' => 'Updated Title',
    ]);
});

test('user can delete an expense', function () {
    $expense = Expense::factory()->create([
        'user_id' => $this->user->id,
    ]);

    $this->delete(route('expenses.destroy', $expense))
        ->assertRedirect(route('expenses.index'));

    $this->assertSoftDeleted('expenses', [
        'id' => $expense->id,
    ]);
});

test('user cannot edit another users expense', function () {
    $otherUser    = User::factory()->create();
    $theirExpense = Expense::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    $this->put(route('expenses.update', $theirExpense), [
        'title'        => 'Hacked!',
        'amount'       => 1,
        'category'     => 'food',
        'expense_date' => now()->format('Y-m-d'),
    ])->assertForbidden();
});

test('user cannot delete another users expense', function () {
    $otherUser    = User::factory()->create();
    $theirExpense = Expense::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    $this->delete(route('expenses.destroy', $theirExpense))
        ->assertForbidden();

    $this->assertDatabaseHas('expenses', [
        'id'         => $theirExpense->id,
        'deleted_at' => null,   // ← confirms it wasn't soft deleted
    ]);
});

test('expense requires title and amount', function () {
    $this->post(route('expenses.store'), [])
        ->assertSessionHasErrors(['title', 'amount']);
});
