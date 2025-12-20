<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('suppliers', function (Blueprint $table) {
        $table->string('SupplierID', 10)->primary();  // SUP001
        $table->string('SupplierName');
        $table->string('SupplierContactNo')->nullable();
        $table->string('Address')->nullable();
        $table->unsignedInteger('ProductSupplied')  // ProductSupplied counter
                  ->default(0);
            $table->enum('Status', ['Active', 'Inactive'])
                  ->default('Active');
        $table->timestamps();
    });
    
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
