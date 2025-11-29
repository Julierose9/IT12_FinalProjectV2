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
    Schema::create('orders', function (Blueprint $table) {
        $table->string('OrderID', 10)->primary();
        $table->string('EmployeeID', 10);

        $table->dateTime('OrderDateTime');
        $table->enum('OrderStatus', ['Completed', 'Cancelled']);
        $table->decimal('SubTotal', 10, 2);
        $table->string('DiscountType')->nullable();
        $table->decimal('DiscountRate', 5, 2)->nullable();
        $table->decimal('DiscountAmount', 10, 2)->nullable();
        $table->decimal('GrandTotal', 10, 2);

        $table->timestamps();

        $table->foreign('EmployeeID')->references('EmployeeID')->on('employees');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
