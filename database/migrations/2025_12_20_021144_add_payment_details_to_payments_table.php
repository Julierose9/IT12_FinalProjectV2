<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentDetailsToPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->decimal('AmountTendered', 10, 2)->default(0)->after('ReferenceNumber');
            $table->decimal('Change', 10, 2)->default(0)->after('AmountTendered');
            $table->decimal('Balance', 10, 2)->default(0)->after('Change');
            $table->string('PaymentStatus', 20)->default('Pending')->after('Balance');
            $table->dateTime('PaymentDate')->nullable()->after('PaymentStatus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['AmountTendered', 'Change', 'Balance', 'PaymentStatus', 'PaymentDate']);
        });
    }
}