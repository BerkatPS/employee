<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        // Create default employees
        Employee::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'position' => 'Software Engineer',
            'department' => 'Engineering',
            'hire_date' => '2024-01-01',
        ]);

        Employee::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'position' => 'HR Manager',
            'department' => 'Human Resources',
            'hire_date' => '2024-01-01',
        ]);

        // Create additional random employees
        Employee::factory()->count(8)->create();
    }
}