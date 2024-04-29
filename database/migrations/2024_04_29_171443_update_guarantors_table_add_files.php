<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateGuarantorsTableAddFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loan_guarantors', function (Blueprint $table) {
            //add
            //'address_proof' => $address_proof,
            //'valid_id' => $valid_id,
            //'passport' => $passport,
            //nationality
            //date of birth
            //all after net_income

            //drop guarantor_passport
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loan_guarantors', function (Blueprint $table) {
            //
        });
    }
}
