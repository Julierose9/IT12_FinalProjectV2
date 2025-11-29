<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'UserID' => 'USR001',
                'EmployeeID' => 'EMP001', // link to employee
                'email' => 'admin@example.com',
                'password' => Hash::make('12345678'),
                'Role' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'UserID' => 'USR002',
                'EmployeeID' => 'EMP002', // link to employee
                'email' => 'cashier@example.com',
                'password' => Hash::make('12345678'),
                'Role' => 'Cashier',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['UserID' => $user['UserID']],
                $user
            );
        }
    }
}
