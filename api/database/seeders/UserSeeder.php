<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Sabino Machado',
            'email' => 'teste@example.com',
            'password' => Hash::make('senha123'),
        ]);
    }
}
