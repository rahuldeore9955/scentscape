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
            ['email' => 'admin@scentscape.com'],
            [
                'name'             => 'Admin',
                'password'         => Hash::make('password'),
                'membership_tier'  => 'gold',
                'is_admin'         => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'priya@example.com'],
            [
                'name'             => 'Priya Sharma',
                'password'         => Hash::make('password'),
                'phone'            => '+91 98765 43210',
                'membership_tier'  => 'gold',
                'is_admin'         => false,
            ]
        );
    }
}
