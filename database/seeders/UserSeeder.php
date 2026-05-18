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
                'name' => 'Jan Kowalski', 'email' => 'jan@email.com',
                'password' => Hash::make('1234'), 'role_id' => 1,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Marta Nowak', 'email' => 'marta@email.com',
                'password' => Hash::make('1234'), 'role_id' => 2,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Paweł Piotrowski', 'email' => 'pawel@email.com',
                'password' => Hash::make('1234'), 'role_id' => 2,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'name' => 'Anna Wiśniewska', 'email' => 'anna@email.com',
                'password' => Hash::make('1234'), 'role_id' => 2,
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
    }
}
