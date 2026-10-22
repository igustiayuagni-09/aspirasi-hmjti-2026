<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permissions (read-only)
        $permissions = [
            'view dashboard',
            'view report',
            'view data',
            'export report',
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
            Permission::firstOrCreate(['name' => 'view review', 'guard_name' => 'web']);
        }

        // Role Reviewer
        $reviewer = Role::firstOrCreate(['name' => 'reviewer']);
        Role::firstOrCreate(['name' => 'reviewer', 'guard_name' => 'web',]);
        $reviewer->syncPermissions([
            'view dashboard',
            'view report',
            'view data',
            'export report',
        ]);

        // Role Admin (contoh)
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());
    }
}
