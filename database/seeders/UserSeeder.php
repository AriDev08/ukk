<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('admin123'),
        ]);

        User::create([
            'name' => 'User Test',
            'email' => 'user@mail.com',
            'password' => Hash::make('user123'),
        ]);
    }
}
