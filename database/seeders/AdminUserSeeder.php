<?php
// database/seeders/AdminUserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
   public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@aspirasi.com'],
            [
                'password' => Hash::make('ucupcomel123'),
            ]
        );

        $admin->assignRole('admin');
    }
}