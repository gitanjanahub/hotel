<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an Admin user
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => Admin::ROLE_ADMIN, // Admin role
        ]);

        // Create a Staff user
        Admin::create([
            'name' => 'Support Staff',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
            'role' => Admin::ROLE_STAFF, // Staff role
        ]);
    }
}
