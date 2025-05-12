<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Create test user
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Create technician
        User::create([
            'name' => 'John Technician',
            'email' => 'tech@example.com',
            'password' => Hash::make('password123'),
            'role' => 'technician',
            'phone_number' => '0771234567',
            'skills' => 'Laptop repair, Smartphone screen replacement, Virus removal',
            'is_active' => true,
        ]);

        // Seed demo data
        $this->call([
            DemoDataSeeder::class,
        ]);
    }
}
