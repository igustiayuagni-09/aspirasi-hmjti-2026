<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed role & permission dulu
        $this->call([
            RolePermissionSeeder::class,
        ]);

        // 2. Admin
        $this->call([
            RolePermissionSeeder::class,
            AdminUserSeeder::class,
            MasterKelasSeeder::class,
        ]);

        // 3. User Reviewer
        $reviewer = User::firstOrCreate(
            ['email' => 'reviewer@aspirasi.com'],
            ['password' => 'aspirasihmjti']
        );

        $reviewer->assignRole('reviewer');

        // 4. User biasa
        User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $this->command->info('Seeding utama selesai.');
    }
}
