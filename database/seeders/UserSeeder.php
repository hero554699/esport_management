<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Use updateOrCreate to avoid duplicates
        User::updateOrCreate(
            ['email' => 'admin@esports.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'viewer@esports.com'],
            [
                'name'     => 'Viewer',
                'password' => Hash::make('password'),
                'role'     => 'viewer',
            ]
        );
    }
}
