<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->integer('nin_status')->after('confirmation')->nullable();
            $table->integer('nin_confirmed_by')->after('nin_status')->nullable();
            $table->timestamp('nin_confirmed_at')->after('nin_confirmed_by')->nullable();
            $table->string('nin_confirmation_channel')->after('nin_confirmed_at')->nullable();
            $table->text('nin_confirmation')->after('nin_confirmation_channel')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('nin')->after('bvn')->nullable();
        });
    }

    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('nin_status');
            $table->dropColumn('nin_confirmed_by');
            $table->dropColumn('nin_confirmed_at');
            $table->dropColumn('nin_confirmation_channel');
            $table->dropColumn('nin_confirmation');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nin');
        });
    }
}
