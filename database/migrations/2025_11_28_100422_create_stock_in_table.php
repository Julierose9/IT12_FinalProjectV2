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
    Schema::create('stock_in', function (Blueprint $table) {
        $table->string('StockInID', 10)->primary();
        $table->string('ProductID', 10);
        $table->string('SupplierID', 10);

        $table->integer('Qty');
        $table->enum('ProdStatus', ['Received', 'Defective', 'Expired']);
        $table->date('DateRcvd');
        $table->date('ExpirationDate');

        $table->timestamps();

        $table->foreign('ProductID')->references('ProductID')->on('products');
        $table->foreign('SupplierID')->references('SupplierID')->on('suppliers');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_in');
    }
};
