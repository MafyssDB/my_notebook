<?php

namespace Database\Seeders;

use App\Models\Finance\Category\ExpenseCategory;
use App\Models\Finance\Category\IncomeCategory;
use App\Models\Finance\Operation\Expense;
use App\Models\Finance\Operation\Income;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(2)->create()->each(function ($user) {
            IncomeCategory::factory(rand(4, 7))->create(['user_id' => $user->id])->each(function (IncomeCategory $incomeCategory) use ($user) {
                Income::factory(rand(5, 10))->create([
                    'category_id' => $incomeCategory->id,
                    'user_id' => $user->id
                ]);
            });

            ExpenseCategory::factory(rand(4, 7))->create(['user_id' => $user->id])->each(function (ExpenseCategory $expenseCategory) use ($user) {
                Expense::factory(rand(5, 10))->create([
                    'category_id' => $expenseCategory->id,
                    'user_id' => $user->id
                ]);
            });
        });
    }
}
