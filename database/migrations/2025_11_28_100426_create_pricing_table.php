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
    Schema::create('pricing', function (Blueprint $table) {
        $table->string('PricingID', 10)->primary();
        $table->string('ProductID', 10);

        $table->decimal('OriginalPrice', 10, 2);
        $table->decimal('RetailPrice', 10, 2);
        $table->decimal('MarkupRate', 5, 2);
        $table->date('EffectiveDate');
        $table->enum('IsActive', ['Yes', 'No']);

        $table->timestamps();

        $table->foreign('ProductID')->references('ProductID')->on('products');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing');
    }
};
