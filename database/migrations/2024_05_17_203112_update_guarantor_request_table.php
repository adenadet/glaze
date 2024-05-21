<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateGuarantorRequestTable extends Migration
{
    public function up()
    {
        Schema::table('loan_guarantor_requests', function (Blueprint $table) {
            $table->string('other_name')->after('first_name')->nullable();
            $table->integer('title')->after('id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('other_name');
            $table->dropColumn('title');
        });
    }
}
