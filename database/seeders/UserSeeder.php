<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat pengguna admin jika belum ada
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'), // Gantilah dengan password yang sesuai
            ]
        )->assignRole('admin');

        // Membuat pengguna staff jika belum ada
        User::firstOrCreate(
            ['email' => 'staff@gmail.com'],
            [
                'name' => 'Staff User',
                'password' => Hash::make('password123'), // Gantilah dengan password yang sesuai
            ]
        )->assignRole('staff');

        // Membuat pengguna biasa jika belum ada
        User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password123'), // Gantilah dengan password yang sesuai
            ]
        )->assignRole('user');
    }
}
