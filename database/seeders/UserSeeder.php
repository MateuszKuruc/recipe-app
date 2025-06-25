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
        User::firstOrCreate(
            ['email' => 'mateuszkuruc@gmail.com'],
            [
                'name' => 'MateuszKuruc',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => \Str::random(10),
            ]
        );
    }
}
