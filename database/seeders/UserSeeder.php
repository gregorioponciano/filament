<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                // Usuário administrador
        User::create([
            'name' => 'Admin',
            'email' => 'admin@demo.com',
            'password' => Hash::make('22222222'),
            'role' => 'admin',

        ]);

                        // Usuário administrador
        User::create([
            'name' => 'Admin1',
            'email' => 'admin1@demo.com',
            'password' => Hash::make('22222222'),
            'role' => 'admin',

        ]);

        // Cliente exemplo
        User::create([
            'name' => 'user',
            'email' => 'user@demo.com',
            'password' => Hash::make('22222222'),
            'role' => 'user',
        ]);
    }
}
