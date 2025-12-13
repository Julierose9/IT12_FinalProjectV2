<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id(); 
            $table->string('EmployeeID', 10)->unique(); 

            $table->string('EmployeeFName', 50);
            $table->string('EmployeeLName', 50);
            $table->string('EmployeeMName', 1)->nullable();
            $table->string('EmployeeContactNum', 20);
            $table->enum('Role', ['Admin', 'Cashier', 'Sales Person']);
            $table->enum('EmployeeStatus', ['Active', 'Inactive', 'On Leave'])->default('Active');
            $table->timestamp('removed_at')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};