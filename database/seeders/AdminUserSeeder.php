<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@seredeit.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@seredeit.com',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin'],
            [
                'name' => 'Admin',
                'email' => 'admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );
    }
}
