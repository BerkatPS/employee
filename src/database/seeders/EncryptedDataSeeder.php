<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EncryptedData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class EncryptedDataSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua employee yang sudah ada
        $employees = Employee::all();

        foreach ($employees as $employee) {
            // Enkripsi nama employee
            EncryptedData::create([
                'model_type' => 'App\\Models\\Employee',
                'model_id' => $employee->id,
                'field_name' => 'name',
                'encrypted_value' => Crypt::encrypt($employee->name),
            ]);

            // Enkripsi email employee
            EncryptedData::create([
                'model_type' => 'App\\Models\\Employee',
                'model_id' => $employee->id,
                'field_name' => 'email',
                'encrypted_value' => Crypt::encrypt($employee->email),
            ]);
        }

        // Tambahkan beberapa data terenkripsi acak untuk testing
        EncryptedData::factory()->count(10)->create();
    }
}