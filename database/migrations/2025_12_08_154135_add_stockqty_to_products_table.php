<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Only add StockQty since ReorderLevel already exists
            if (!Schema::hasColumn('products', 'StockQty')) {
                $table->integer('StockQty')->default(0)->after('ProductDescription');
            }
            
            // Check if ReorderLevel exists before adding
            if (!Schema::hasColumn('products', 'ReorderLevel')) {
                $table->integer('ReorderLevel')->default(10)->after('StockQty');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Only drop if they exist
            if (Schema::hasColumn('products', 'StockQty')) {
                $table->dropColumn('StockQty');
            }
            if (Schema::hasColumn('products', 'ReorderLevel')) {
                $table->dropColumn('ReorderLevel');
            }
        });
    }
};