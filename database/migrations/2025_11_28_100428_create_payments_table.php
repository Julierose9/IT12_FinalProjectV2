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
    Schema::create('payments', function (Blueprint $table) {
        $table->string('PaymentID', 10)->primary();
        $table->string('OrderID', 10);

        $table->enum('PaymentType', ['Cash', 'GCash']);
        $table->string('ReferenceNumber')->nullable();

        $table->timestamps();

        $table->foreign('OrderID')->references('OrderID')->on('orders');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
