<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Define all permissions
        $permissions = [
            'is super admin',
            'can view users',
            'can delete users',
            'can edit users',
            'can add users',
            'can view products',
            'can add products',
            'can edit products',
            'can delete products',
        ];

        // Create each permission
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Assign permissions to roles
        // Super Admin gets all permissions
        $superAdminRole->syncPermissions(Permission::all());

        // Admin gets a subset of permissions
        $adminPermissions = [
            'can view users',
            'can delete users',
            'can edit users',
            'can add users',
            'can view products',
            'can add products',
            'can edit products',
        ];
        $adminRole->syncPermissions($adminPermissions);

        $this->command->info('Permissions and roles have been seeded successfully.');
    }
}
