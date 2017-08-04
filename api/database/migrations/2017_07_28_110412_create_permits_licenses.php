<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermitsLicenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permits_licenses', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('project_id')->unsigned()->nullable();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->integer('regulation')->unsigned()->nullable();
            $table->date('date_submitted')->nullable();
            // FIL (1): Application form
            // FIL (mange): Attachment files
            $table->integer('waste_license_type')->unsigned()->nullable();
            $table->integer('ecosystem')->unsigned()->nullable();
            $table->integer('regulation_activity')->unsigned()->nullable();
            $table->decimal('area', 24, 6)->nullable();
            $table->integer('unit')->unsigned()->nullable();
            $table->boolean('approved_by_the_lc1')->default(false)->nullable();
            $table->boolean('approved_by_the_dec')->default(false)->nullable();
            $table->integer('application_number')->unsigned()->nullable();
            $table->string('application_fee_receipt_number', 2000)->nullable();
            $table->date('date_feedback_to_applicants')->nullable();
            $table->date('date_sent_to_director')->nullable();
            $table->date('date_sent_from_dep')->nullable();
            $table->date('date_sent_officer')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('application_evaluation_by_officer')->unsigned()->nullable();
            $table->date('date_of_evaluation')->nullable();
            $table->string('folio_no', 255)->nullable();
            $table->integer('inspection_recommended')->unsigned()->nullable();
            $table->date('date_inspection')->nullable();
            $table->string('officer_recommend', 2000)->nullable();
            $table->string('fee_receipt_no', 255)->nullable();
            $table->date('date_fee_payed')->nullable();
            $table->date('date_sent_to_ed_for_decision')->nullable();
            $table->integer('decision')->unsigned()->nullable();
            $table->date('date_decision')->nullable();
            $table->integer('signature_on_permit_license')->unsigned()->nullable();
            $table->date('date_permit_license')->nullable();
            $table->integer('permit_license_no')->unsigned()->nullable();
            $table->date('date_permit_license_expired')->nullable();
            // FIL (1): Permit/license
            $table->integer('status')->unsigned()->nullable();
            $table->softDeletes();
            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();

        });

        Schema::create('permits_licenses_personnel', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('permit_license_id')->unsigned()->nullable();
            $table->foreign('permit_license_id')->references('id')->on('permits_licenses');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('permits_licenses_documents', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('permits_licenses_id')->unsigned()->nullable();
            $table->foreign('permits_licenses_id')->references('id')->on('permits_licenses');
            $table->integer('file_metadata_id')->unsigned()->nullable();
            $table->foreign('file_metadata_id')->references('id')->on('file_metadata');
            $table->integer('tag')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permits_licenses_documents', function(Blueprint $table){});
        Schema::dropIfExists('permits_licenses_personnel', function(Blueprint $table){});
        Schema::dropIfExists('permits_licenses', function(Blueprint $table){});
    }
}
