<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed employees first
        $this->call(EmployeeSeeder::class);

        // Then seed users
        $this->call(UserSeeder::class);

        $this->call(CategorySeeder::class);


    }
}
