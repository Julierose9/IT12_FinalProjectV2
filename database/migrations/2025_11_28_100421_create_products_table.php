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
    Schema::create('products', function (Blueprint $table) {
        $table->string('ProductID', 10)->primary();
        $table->string('SKUNumber')->unique();
        $table->string('ProductName');
        $table->text('ProductDescription')->nullable();
        $table->integer('ReorderLevel')->default(0);
        $table->enum('ProductStatus', ['Active', 'Inactive']);

        $table->string('SupplierID', 10);
        $table->string('CategoryID', 10);

        $table->timestamps();

        $table->foreign('SupplierID')->references('SupplierID')->on('suppliers');
        $table->foreign('CategoryID')->references('CategoryID')->on('categories');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
