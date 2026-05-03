<?php
// tests/Pest.php

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class)->in(
    'Feature/Auth',           // ← Breeze auth tests
    'Feature/ExampleTest.php', // ← example test
    'Feature/BudgetTest.php',
    'Feature/ExpenseTest.php',
    'Feature/NotificationTest.php',
    'Feature/ProfileTest.php',
    'Unit',
);
