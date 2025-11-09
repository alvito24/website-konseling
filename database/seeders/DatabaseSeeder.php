<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin
        User::create([
            'name' => 'Admin Keren',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);

        // Create guru BK
        User::create([
            'name' => 'Guru BK Gaul',
            'email' => 'gurubk@example.com',
            'password' => bcrypt('password'),
            'role' => 'guru_bk',
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);

        // Create siswa
        User::create([
            'name' => 'Siswa Rajin',
            'email' => 'siswa@example.com',
            'password' => bcrypt('password'),
            'role' => 'siswa',
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);
    }
}
