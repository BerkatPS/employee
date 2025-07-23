<?php

namespace Database\Factories;

use App\Models\EncryptedData;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Crypt;

class EncryptedDataFactory extends Factory
{
    protected $model = EncryptedData::class;

    public function definition(): array
    {
        return [
            'model_type' => 'App\\Models\\Employee',
            'model_id' => Employee::factory(),
            'field_name' => fake()->randomElement(['name', 'email']),
            'encrypted_value' => Crypt::encrypt(fake()->name()),
        ];
    }

    public function forEmployee(Employee $employee, string $fieldName, string $value): self
    {
        return $this->state(function (array $attributes) use ($employee, $fieldName, $value) {
            return [
                'model_type' => 'App\\Models\\Employee',
                'model_id' => $employee->id,
                'field_name' => $fieldName,
                'encrypted_value' => Crypt::encrypt($value),
            ];
        });
    }
}