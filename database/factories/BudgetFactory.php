<?php
// database/factories/BudgetFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BudgetFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'  => \App\Models\User::factory(),
            'category' => $this->faker->randomElement([
                'food',
                'travel',
                'health',
                'office',
                'shopping'
            ]),
            'amount'   => $this->faker->numberBetween(100, 1000),
            // ← NO title, NO expense_date, NO notes
        ];
    }
}
