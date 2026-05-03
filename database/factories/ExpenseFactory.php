<?php
// database/factories/ExpenseFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'      => \App\Models\User::factory(),
            'title'        => $this->faker->sentence(3),
            'amount'       => $this->faker->randomFloat(2, 10, 500),
            'category'     => $this->faker->randomElement([
                'food',
                'travel',
                'health',
                'office',
                'shopping'
            ]),
            'expense_date' => $this->faker->dateTimeThisMonth(), // ← matches your column
            'description' => $this->faker->optional()->sentence(),
        ];
    }
}
