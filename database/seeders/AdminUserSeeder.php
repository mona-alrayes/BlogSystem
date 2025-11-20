<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin role if it doesn't exist
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin', 'guard_name' => 'api'],
            ['name' => 'admin', 'guard_name' => 'api']
        );

        //create user role if it doesn't exist
        $userRole = Role::firstOrCreate(
            ['name' => 'user', 'guard_name' => 'api'],
            ['name' => 'user', 'guard_name' => 'api']
        );
        // Create admin user
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Assign admin role to user
        $adminUser->assignRole($adminRole);
        
    }
}
