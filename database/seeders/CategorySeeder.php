<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['CategoryID' => 'CAT001', 'CategoryName' => 'Beauty'],
            ['CategoryID' => 'CAT002', 'CategoryName' => 'Accessories'],
            ['CategoryID' => 'CAT003', 'CategoryName' => 'School Supplies'],
            ['CategoryID' => 'CAT004', 'CategoryName' => 'Jewelry'],
            ['CategoryID' => 'CAT005', 'CategoryName' => 'Bags'],
            ['CategoryID' => 'CAT006', 'CategoryName' => 'RTW'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                ['CategoryID' => $category['CategoryID']],  // condition
                [
                    'CategoryName' => $category['CategoryName'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ] // update values
            );
        }
    }
}
