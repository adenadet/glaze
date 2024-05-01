<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCustomerAddressVerificationMakeMultiuse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_address_verifications', function (Blueprint $table) {
            $table->text('address_type')->after('id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('customer_address_verifications', function (Blueprint $table) {
            $table->dropColumn('address_type');
        });
    }
}
