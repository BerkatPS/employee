<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();
        $statuses = ['present', 'late', 'absent'];

        foreach ($employees as $employee) {
            // Buat data absensi untuk 30 hari terakhir
            for ($i = 0; $i < 30; $i++) {
                $date = now()->subDays($i);
                $status = $statuses[array_rand($statuses)];

                if ($status !== 'absent') {
                    $checkIn = $date->copy()->setTimeFromTimeString($status === 'present' ? '08:00:00' : '09:30:00');
                    $checkOut = $date->copy()->setTimeFromTimeString('17:00:00');
                } else {
                    $checkIn = null;
                    $checkOut = null;
                }

                Attendance::create([
                    'employee_id' => $employee->id,
                    'date' => $date->toDateString(),
                    'check_in' => $checkIn,
                    'check_out' => $checkOut,
                    'status' => $status,
                ]);
            }
        }
    }
}