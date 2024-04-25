<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLoanCreditScoreTable extends Migration
{
    public function up()
    {
        Schema::table('loan_account_credit_scores', function (Blueprint $table) {
            $table->text('validation_type')->after('response');
        });
    }

    public function down()
    {
        Schema::table('loan_account_credit_scores', function (Blueprint $table) {
            $table->dropColumn('validation_type');
        });
    }
}
