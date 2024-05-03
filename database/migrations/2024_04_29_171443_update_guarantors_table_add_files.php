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

            $table->integer('employer_address_confirmed_by')->nullable()->after('employer_address');
            $table->timestamp('employer_address_confirmed_at')->nullable()->after('employer_address_confirmed_by');
            $table->integer('employer_address_status')->nullable()->after('employer_address_confirmed_at');

            $table->text('residential_address')->nullable()->after('employer_address_status');
            $table->integer('residential_address_confirmed_by')->nullable()->after('residential_address');
            $table->timestamp('residential_address_confirmed_at')->nullable()->after('residential_address_confirmed_by');
            $table->integer('residential_address_status')->nullable()->after('residential_address_confirmed_at');

            $table->integer('bvn_status')->nullable()->after('bvn');
            $table->integer('bvn_confirmed_by')->nullable()->after('bvn_status');
            $table->integer('bvn_confirmed_at')->nullable()->after('bvn_confirmed_by');
            $table->string('nin')->nullable()->after('bvn_confirmed_at');
            $table->string('nin_status')->nullable()->after('nin');
            $table->string('nin_confirmed_by')->nullable()->after('nin_status');
            $table->string('nin_confirmed_at')->nullable()->after('nin_confirmed_by');
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
