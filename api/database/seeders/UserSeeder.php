<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Sabino Machado',
            'email' => 'teste@example.com',
            'password' => Hash::make('senha123'),
        ]);

        User::factory(20)->create([
            'password' => Hash::make('senha123'),
        ]);
    }
}
