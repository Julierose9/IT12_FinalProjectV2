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
        Schema::create('users', function (Blueprint $table) {
            $table->string('UserID', 10)->primary();
            $table->string('EmployeeID', 10)->nullable(); // <-- column must exist
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('Role', ['Admin', 'Cashier']);
            $table->timestamps();
        
            // Foreign key after defining the column
            $table->foreign('EmployeeID')->references('EmployeeID')->on('employees')->onDelete('cascade');
        });
    }        

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
