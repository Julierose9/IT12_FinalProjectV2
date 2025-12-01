<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            
            // EXACT ORDER YOU REQUESTED
            $table->string('SupplierName');                    // SupplierName
            $table->string('SupplierContactNum');              // SupplierContactNo
            $table->text('Address');                      // Address
            $table->unsignedInteger('Product Supplied')  // ProductSupplied counter
                  ->default(0);
            $table->enum('Status', ['Active', 'Inactive', 'Pending'])
                  ->default('Pending');                  // Status
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
};