<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuarantorAddressVerificationsTable extends Migration
{
    public function up()
    {
        Schema::create('loan_guarantor_address_verifications', function (Blueprint $table) {
            $table->id();
            $table->integer('guarantor_id'); 
            $table->string('address_type'); 
            $table->text('alternate_address')->nullable(); 
            $table->text('description')->nullable(); 
            $table->string('location_ease')->nullable(); 
            $table->string('met_with')->nullable();
            $table->string('met_with_name')->nullable(); 
            $table->string('met_with_relations')->nullable();
            $table->string('met_with_phone')->nullable(); 
            $table->text('remarks')->nullable(); 
            $table->string('visit_update')->nullable();
            $table->date('visit_date');
            $table->date('visit_date_2')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by'); 
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('loan_guarantor_address_verifications');
    }
}
