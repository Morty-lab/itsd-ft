<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ensure RoleSeeder is executed
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);

        // Create a user with the Admin roles
        $user = User::factory()->create([
            'name' => 'Anie Joseph Cabahug',
            'email' => 'cabahuganiejoseph@gmail.com',
            'password' => bcrypt('testpassword'), // Correctly hash the password
        ]);

        // Assign Admin roles to the created user
        $user->assignRole('super admin');
    }
}
