<?php
// database/seeders/AdminSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Ali',
            'email' => 'ali@gmail.com',
            'password' => Hash::make('admin123'), // À changer en production
            'role' => 'admin',
            'status' => 'approved',
            'phone' => '21863548',
            'email_verified_at' => now(),
        ]);

        // Créer quelques utilisateurs de test
        User::create([
            'name' => '3eljia',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'status' => 'approved',
            'phone' => '22123456',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => '3eljiyaaaaa',
            'email' => 'user2@gmail.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'status' => 'pending',
            'phone' => '23456789',
            'email_verified_at' => now(),
        ]);
    }
}
