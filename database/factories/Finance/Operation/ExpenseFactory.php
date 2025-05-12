<?php

namespace Database\Factories\Finance\Operation;

use App\Models\Finance\Category\ExpenseCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Finance\Operation\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'amount' => $this->faker->randomFloat(2,1,10000),
            'description' => $this->faker->text(20),
            'category_id' => ExpenseCategory::factory(),
            'date_operation' => $this->faker->dateTimeBetween('2025-01-01', '2025-05-30')->format('Y-m-d'),
        ];
    }
}
