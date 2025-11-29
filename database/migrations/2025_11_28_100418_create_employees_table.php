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
    Schema::create('employees', function (Blueprint $table) {
        $table->string('EmployeeID', 10)->primary();
        $table->string('EmployeeFName');
        $table->string('EmployeeLName');
        $table->string('EmployeeMName')->nullable();
        $table->string('EmployeeContactNum');
        $table->enum('Role', ['Admin', 'Cashier']);
        $table->enum('EmployeeStatus', ['Active', 'Inactive']);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
