<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateGuarantorsTableAddFiles extends Migration
{
    public function up()
    {
        Schema::table('loan_guarantors', function (Blueprint $table) {
            $table->text('address_proof')->after('guarantor_passport');
            $table->text('valid_id')->after('address_proof');
            $table->text('passport')->after('valid_id');
            $table->text('dob')->after('phone');
            $table->text('nationality_id')->after('dob');
        });
    }

    public function down()
    {
        Schema::table('loan_guarantors', function (Blueprint $table) {
            $table->dropColumn('address_proof');
            $table->dropColumn('valid_id');
            $table->dropColumn('passport');
            $table->dropColumn('dob');
            $table->dropColumn('nationality_id');
        });
    }
}
