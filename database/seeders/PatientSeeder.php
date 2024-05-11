<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Patient::create(
            [
                'user_id' => 3,
                'cpf' => '12345678901',
                'sex' => 'M',
                'date_birth' => '1980-01-01',
                'phone' => '1234567890',
                'address' => '1234 Main St',
                'city' => 'Goiania',
                'state' => 'GO',
            ]
        );
    }
}
