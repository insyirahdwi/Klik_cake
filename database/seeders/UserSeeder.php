<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'pinkycake@gmail.com'],
            [
                'name' => 'Admin Pinky Cake',
                'password' => Hash::make('adminpinky123'),
                'role' => 'admin',
                'phone' => '081234567890',
                'email_verified_at' => now(),
            ]
        );
    }
}
