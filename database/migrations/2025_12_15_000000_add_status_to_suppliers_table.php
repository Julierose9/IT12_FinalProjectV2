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
        Schema::table('suppliers', function (Blueprint $table) {
            // Add Status column if it doesn't exist yet
            if (!Schema::hasColumn('suppliers', 'Status')) {
                $table->enum('Status', ['Active', 'Inactive', 'Pending'])
                      ->default('Pending')
                      ->after('ProductSupplied');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            if (Schema::hasColumn('suppliers', 'Status')) {
                $table->dropColumn('Status');
            }
        });
    }
};


