<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLoanGuarantorsTableAddApproval extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loan_guarantors', function (Blueprint $table) {
            $table->text('approve_bvn_remark')->after('guarantor_date')->nullable();
            $table->integer('approve_bvn_status')->after('guarantor_date')->nullable();
            $table->date('approve_bvn_date')->after('guarantor_date')->nullable();
            $table->integer('approve_bvn_by')->after('guarantor_date')->nullable();
        });
    }

    public function down()
    {
        Schema::table('loan_guarantors', function (Blueprint $table) {
            $table->dropColumn('approve_bvn_remark');
            $table->dropColumn('approve_bvn_status');
            $table->dropColumn('approve_bvn_date');
            $table->dropColumn('approve_bvn_by');
        });
    }
}
