<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLoanCreditScoreTable extends Migration
{
    public function up()
    {
        /*Schema::create('loan_account_credit_scores', function (Blueprint $table) {
            $table->id();
            $table->integer('loan_id'); 
            $table->string('credit_score'); 
            $table->integer('product_id'); 
            $table->text('response'); 
            $table->text('validation_type'); 
            $table->integer('created_by'); 
            $table->integer('updated_by'); 
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });*/

        Schema::table('loan_account_credit_scores', function (Blueprint $table) {
            $table->string('validation_type')->after('response');
        });
    }

    public function down()
    {
        Schema::table('loan_account_credit_scores', function (Blueprint $table) {
            $table->dropColumn('validation_type');
        });
    }
}
