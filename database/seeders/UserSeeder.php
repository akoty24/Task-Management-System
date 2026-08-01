<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create user
        User::create([
            'name' => 'Mohamed Saber',
            'email' => 'm.saber@gmail.com',
            'password' => Hash::make('123456789'),
            'email_verified_at' => now(),
        ]);
    }
}
