<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'position' => fake()->jobTitle(),
            'department' => fake()->randomElement(['Engineering', 'Human Resources', 'Finance', 'Marketing', 'Sales']),
            'hire_date' => fake()->dateTimeBetween('-2 years', 'now'),
        ];
    }
}