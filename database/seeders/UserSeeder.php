<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::truncate();
        User::insert([
            [
                'name' => 'Jan', 'email' => 'jan@email.com',
                'password' => Hash::make('1234'),
                'country_id' => 5, 'role_id' => 1,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Siu Hun', 'email' => 'siuhun@email.com',
                'password' => Hash::make('1234'),
                'country_id' => 2, 'role_id' => 2,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Helmut', 'email' => 'helmut@email.com',
                'password' => Hash::make('1234'),
                'country_id' => 3, 'role_id' => 2,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Marta', 'email' => 'marta@email.com',
                'password' => Hash::make('1234'),
                'country_id' => 5, 'role_id' => 2,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Bill', 'email' => 'bill@email.com',
                'password' => Hash::make('1234'),
                'country_id' => 1, 'role_id' => 2,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Lilly', 'email' => 'lilly@email.com',
                'password' => Hash::make('1234'),
                'country_id' => 6, 'role_id' => 2,
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }
}
