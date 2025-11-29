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
    Schema::create('pull_out', function (Blueprint $table) {
        $table->string('PullOutID', 10)->primary();
        $table->string('EmployeeID', 10);
        $table->string('ProductID', 10);

        $table->integer('PullOutQty');
        $table->text('PullOutReason');
        $table->enum('PullOutType', ['Damaged', 'Lost', 'Returned to Supplier', 'Expired']);
        $table->date('DatePullOut');

        $table->timestamps();

        $table->foreign('EmployeeID')->references('EmployeeID')->on('employees');
        $table->foreign('ProductID')->references('ProductID')->on('products');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pull_out');
    }
};
