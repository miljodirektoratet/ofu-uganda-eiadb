<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExternalAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_audits', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('project_id')->unsigned()->nullable();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->integer('teamleader_id')->unsigned()->nullable();
            $table->integer('type')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('verification_inspection')->unsigned()->nullable();
            $table->date('date_inspection')->nullable();
            $table->date('date_response')->nullable();
            $table->integer('file_metadata_response_id')->unsigned()->nullable();
            $table->foreign('file_metadata_response_id')->references('id')->on('file_metadata');
            $table->integer('response')->unsigned()->nullable();
            $table->string('review_findings', 2000)->nullable();
            $table->date('date_deadline_compliance')->nullable();
            $table->integer('status')->unsigned()->nullable();
            $table->softDeletes();
            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('team_members_external_audits', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('practitioner_id')->unsigned()->nullable();
            $table->foreign('practitioner_id')->references('id')->on('practitioners');
            $table->integer('external_audit_id')->unsigned()->nullable();
            $table->foreign('external_audit_id')->references('id')->on('external_audits');
        });

        Schema::create('external_audits_personnel', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('external_audit_id')->unsigned()->nullable();
            $table->foreign('external_audit_id')->references('id')->on('external_audits');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_audits_personnel', function(Blueprint $table){});
        Schema::dropIfExists('team_members_external_audits', function(Blueprint $table){});
        Schema::dropIfExists('external_audits', function(Blueprint $table){});
    }
}