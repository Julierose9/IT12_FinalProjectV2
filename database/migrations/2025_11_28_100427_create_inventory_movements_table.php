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
    Schema::create('inventory_movements', function (Blueprint $table) {
        $table->string('InventoryID', 10)->primary();
        $table->string('ProductID', 10);

        $table->integer('QtyChange');
        $table->enum('ChangeType', ['Increase', 'Decrease']);
        $table->dateTime('ChangeDateTime');

        $table->timestamps();

        $table->foreign('ProductID')->references('ProductID')->on('products');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
