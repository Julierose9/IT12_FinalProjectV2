<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            // Auto-incrementing BIG INT ID (standard Laravel way)
            $table->id(); // creates `id` BIGINT UNSIGNED AUTO_INCREMENT

            // Custom formatted employee code (e.g., EMP001, EMP042)
            $table->string('EmployeeID', 10)->unique(); // This will be "EMP001"

            $table->string('EmployeeFName', 50);
            $table->string('EmployeeLName', 50);
            $table->string('EmployeeMName', 1)->nullable();
            $table->string('EmployeeContactNum', 20);
            $table->enum('Role', ['Admin', 'Cashier', 'Manager']);
            $table->enum('EmployeeStatus', ['Active', 'Inactive', 'On Leave'])->default('Active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};