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
    Schema::create('order_details', function (Blueprint $table) {
        $table->string('OrderDetailsID', 10)->primary();
        $table->string('OrderID', 10);
        $table->string('ProductID', 10);

        $table->integer('OrderQty');

        $table->timestamps();

        $table->foreign('OrderID')->references('OrderID')->on('orders');
        $table->foreign('ProductID')->references('ProductID')->on('products');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
