<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $employees = [
            [
                'EmployeeID' => 'EMP001',
                'EmployeeFName' => 'Elena',
                'EmployeeLName' => 'Marquez',
                'EmployeeMName' => 'A',
                'EmployeeContactNum' => '09171234567',
                'Role' => 'Admin',
                'EmployeeStatus' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'EmployeeID' => 'EMP002',
                'EmployeeFName' => 'Juan',
                'EmployeeLName' => 'Dela Cruz',
                'EmployeeMName' => null,
                'EmployeeContactNum' => '09179876543',
                'Role' => 'Cashier',
                'EmployeeStatus' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($employees as $employee) {
            DB::table('employees')->updateOrInsert(
                ['EmployeeID' => $employee['EmployeeID']],
                $employee
            );
        }
    }
}
