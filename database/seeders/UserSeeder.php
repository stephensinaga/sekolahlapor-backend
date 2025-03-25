<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'password' => 'superadmin123',
                'role' => 'superadmin',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => 'admin123',
                'role' => 'admin',
            ],
            [
                'name' => 'Petugas',
                'email' => 'petugas@gmail.com',
                'password' => 'petugas123',
                'role' => 'petugas',
            ],
            [
                'name' => 'Kepala Wisma Putra',
                'email' => 'kepalawismaputra@gmail.com',
                'password' => 'wisma123',
                'role' => 'petugas',
            ],
            [
                'name' => 'Kepala Wisma Putri',
                'email' => 'kepalawismaputri@gmail.com',
                'password' => 'wisma123',
                'role' => 'petugas',
            ],
            [
                'name' => 'Wakasis',
                'email' => 'wakasis@gmail.com',
                'password' => 'wakasis123',
                'role' => 'petugas',
            ],
            [
                'name' => 'Waka Sarpras',
                'email' => 'wakapras@gmail.com',
                'password' => 'wakapras123',
                'role' => 'petugas',
            ],
            [
                'name' => 'Guru Piket',
                'email' => 'gurupiket@gmail.com',
                'password' => 'gurupiket123',
                'role' => 'petugas',
            ],
            [
                'name' => 'Sutik',
                'email' => 'sutik@gmail.com',
                'password' => 'sutik123',
                'role' => 'petugas',
            ],
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => 'user123',
                'role' => 'user',
            ],
        ];

        foreach ($users as $key => $val) {
            User::create($val);
        }
    }
}
