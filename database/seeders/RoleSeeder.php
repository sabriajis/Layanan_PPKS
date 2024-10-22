<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'staff', 'guard_name' => 'web']);

        // Membuat role jika belum ada
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // Buat pengguna admin jika belum ada
        $userAdmin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'], // Pastikan email unik
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'), // Pastikan password yang kuat
            ]

        );
        $userAdmin->givePermissionTo('view users');
        // Assign role admin ke pengguna
        $userAdmin->assignRole($adminRole);
}

}
