<?php

namespace Database\Factories;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition(): array
    {
        $status = fake()->randomElement(['present', 'late', 'absent']);
        $checkIn = null;
        $checkOut = null;

        if ($status !== 'absent') {
            $checkIn = $status === 'present' ? '08:00' : '09:30';
            $checkOut = '17:00';
        }

        return [
            'employee_id' => \App\Models\Employee::factory(),
            'date' => fake()->dateTimeBetween('-30 days', 'now'),
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'status' => $status,
        ];
    }

    public function present(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'present',
                'check_in' => '08:00',
                'check_out' => '17:00',
            ];
        });
    }

    public function late(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'late',
                'check_in' => '09:30',
                'check_out' => '17:00',
            ];
        });
    }

    public function absent(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'absent',
                'check_in' => null,
                'check_out' => null,
            ];
        });
    }
}