<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Salary;
use Illuminate\Database\Seeder;

class SalarySeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();

        foreach ($employees as $employee) {
            // Buat data gaji untuk 3 bulan terakhir
            for ($i = 0; $i < 3; $i++) {
                Salary::create([
                    'employee_id' => $employee->id,
                    'basic_salary' => rand(5000000, 10000000),
                    'allowance' => rand(1000000, 2000000),
                    'tax_deduction' => rand(500000, 1000000),
                    'month' => now()->subMonths($i)->startOfMonth(),
                ]);
            }
        }
    }
}