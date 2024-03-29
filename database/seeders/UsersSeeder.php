<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'name' => 'Ellington Machado',
            'email' => 'ellington1209@gmail.com',
            'password' => Hash::make('123456'),
            'perfils_id' => 1,
            'telefone' => '62991720735',
            'endereco' => 'rua rubiataba qd85 lt 14',
            'rg' => '5044009',
            'cpf' => '01929218192',
        ]);
    }
}
