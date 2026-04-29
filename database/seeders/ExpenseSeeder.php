<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {
        // Get the first user or create one
        $user = User::first() ?? User::factory()->create([
            'name'     => 'Mohammed Maheen',
            'email'    => 'maheen@example.com',
            'password' => bcrypt('password'),
        ]);

        // ── Sample Expenses ────────────────────────────
        $expenses = [

            // This week
            [
                'title'        => 'Team lunch',
                'amount'       => 45.50,
                'category'     => 'food',
                'expense_date' => now()->startOfWeek()->format('Y-m-d'),
                'description'  => 'Lunch with the dev team',
            ],
            [
                'title'        => 'Uber to office',
                'amount'       => 12.00,
                'category'     => 'travel',
                'expense_date' => now()->startOfWeek()->addDay()->format('Y-m-d'),
                'description'  => 'Ride to office',
            ],
            [
                'title'        => 'Printer paper',
                'amount'       => 8.75,
                'category'     => 'office',
                'expense_date' => now()->startOfWeek()->addDays(2)->format('Y-m-d'),
                'description'  => 'A4 paper for office printer',
            ],

            // This month
            [
                'title'        => 'Doctor visit',
                'amount'       => 80.00,
                'category'     => 'health',
                'expense_date' => now()->startOfMonth()->addDays(3)->format('Y-m-d'),
                'description'  => 'General checkup',
            ],
            [
                'title'        => 'Grocery shopping',
                'amount'       => 65.20,
                'category'     => 'food',
                'expense_date' => now()->startOfMonth()->addDays(5)->format('Y-m-d'),
                'description'  => 'Weekly groceries',
            ],
            [
                'title'        => 'Flight ticket',
                'amount'       => 320.00,
                'category'     => 'travel',
                'expense_date' => now()->startOfMonth()->addDays(7)->format('Y-m-d'),
                'description'  => 'Round trip to Karachi',
            ],
            [
                'title'        => 'Office chair',
                'amount'       => 150.00,
                'category'     => 'office',
                'expense_date' => now()->startOfMonth()->addDays(10)->format('Y-m-d'),
                'description'  => 'Ergonomic chair for home office',
            ],
            [
                'title'        => 'Pharmacy',
                'amount'       => 25.50,
                'category'     => 'health',
                'expense_date' => now()->startOfMonth()->addDays(12)->format('Y-m-d'),
                'description'  => 'Monthly medicines',
            ],
            [
                'title'        => 'Restaurant dinner',
                'amount'       => 55.00,
                'category'     => 'food',
                'expense_date' => now()->startOfMonth()->addDays(14)->format('Y-m-d'),
                'description'  => 'Family dinner',
            ],
            [
                'title'        => 'Miscellaneous',
                'amount'       => 30.00,
                'category'     => 'other',
                'expense_date' => now()->startOfMonth()->addDays(15)->format('Y-m-d'),
                'description'  => 'Random purchases',
            ],

            // 2 months ago
            [
                'title'        => 'Hotel stay',
                'amount'       => 210.00,
                'category'     => 'travel',
                'expense_date' => now()->subMonths(2)->format('Y-m-d'),
                'description'  => '2 night stay',
            ],
            [
                'title'        => 'Gym membership',
                'amount'       => 40.00,
                'category'     => 'health',
                'expense_date' => now()->subMonths(2)->addDays(5)->format('Y-m-d'),
                'description'  => 'Monthly gym fee',
            ],
            [
                'title'        => 'Coffee and snacks',
                'amount'       => 18.00,
                'category'     => 'food',
                'expense_date' => now()->subMonths(2)->addDays(8)->format('Y-m-d'),
                'description'  => 'Morning coffee run',
            ],

            // 3 months ago
            [
                'title'        => 'Laptop stand',
                'amount'       => 35.00,
                'category'     => 'office',
                'expense_date' => now()->subMonths(3)->format('Y-m-d'),
                'description'  => 'Portable laptop stand',
            ],
            [
                'title'        => 'Bus pass',
                'amount'       => 22.00,
                'category'     => 'travel',
                'expense_date' => now()->subMonths(3)->addDays(3)->format('Y-m-d'),
                'description'  => 'Monthly bus pass',
            ],
            [
                'title'        => 'Eye checkup',
                'amount'       => 60.00,
                'category'     => 'health',
                'expense_date' => now()->subMonths(3)->addDays(6)->format('Y-m-d'),
                'description'  => 'Annual eye test',
            ],

            // 4 months ago
            [
                'title'        => 'Team dinner',
                'amount'       => 95.00,
                'category'     => 'food',
                'expense_date' => now()->subMonths(4)->format('Y-m-d'),
                'description'  => 'End of sprint celebration',
            ],
            [
                'title'        => 'Stationery',
                'amount'       => 15.00,
                'category'     => 'office',
                'expense_date' => now()->subMonths(4)->addDays(4)->format('Y-m-d'),
                'description'  => 'Pens and notebooks',
            ],

            // 5 months ago
            [
                'title'        => 'Train tickets',
                'amount'       => 48.00,
                'category'     => 'travel',
                'expense_date' => now()->subMonths(5)->format('Y-m-d'),
                'description'  => 'Weekend trip',
            ],
            [
                'title'        => 'Vitamins',
                'amount'       => 20.00,
                'category'     => 'health',
                'expense_date' => now()->subMonths(5)->addDays(2)->format('Y-m-d'),
                'description'  => 'Monthly vitamins',
            ],
            [
                'title'        => 'Lunch delivery',
                'amount'       => 28.00,
                'category'     => 'food',
                'expense_date' => now()->subMonths(5)->addDays(5)->format('Y-m-d'),
                'description'  => 'Food delivery order',
            ],
            [
                'title'        => 'Freelance tools',
                'amount'       => 75.00,
                'category'     => 'other',
                'expense_date' => now()->subMonths(5)->addDays(8)->format('Y-m-d'),
                'description'  => 'Software subscriptions',
            ],
        ];

        // Insert all expenses for this user
        foreach ($expenses as $expense) {
            Expense::create([
                ...$expense,
                'user_id' => $user->id,
            ]);
        }

        $this->command->info('✅ ' . count($expenses) . ' expenses seeded for ' . $user->name);
    }
}