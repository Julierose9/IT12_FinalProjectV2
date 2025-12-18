<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add an auto-increment sequence column for generating unique PricingIDs
        // This will help ensure we always get unique IDs
        if (!Schema::hasTable('pricing_sequence')) {
            Schema::create('pricing_sequence', function (Blueprint $table) {
                $table->id('seq_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_sequence');
    }
};
