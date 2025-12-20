<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // In the new migration file
public function up()
{
    Schema::table('stock_in', function (Blueprint $table) {
        $table->date('ExpirationDate')->nullable()->change();
    });
}

public function down()
{
    Schema::table('stock_in', function (Blueprint $table) {
        $table->date('ExpirationDate')->nullable(false)->change();
    });
}
};
