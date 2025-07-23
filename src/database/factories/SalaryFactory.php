<?php

namespace Database\Factories;

use App\Models\Salary;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalaryFactory extends Factory
{
    protected $model = Salary::class;

    public function definition(): array
    {
        return [
            'employee_id' => \App\Models\Employee::factory(),
            'basic_salary' => fake()->numberBetween(5000000, 10000000),
            'allowance' => fake()->numberBetween(1000000, 2000000),
            'tax_deduction' => fake()->numberBetween(500000, 1000000),
            'month' => fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
        ];
    }
}