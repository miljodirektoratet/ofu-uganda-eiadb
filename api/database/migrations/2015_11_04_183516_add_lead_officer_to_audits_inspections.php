<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLeadOfficerToAuditsInspections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audits_inspections', function (Blueprint $table)
        {
            $table->integer('lead_officer')->unsigned()->nullable()->after('remarks');
            $table->foreign('lead_officer')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audits_inspections', function (Blueprint $table)
        {
            $table->dropForeign('audits_inspections_lead_officer_foreign');
            $table->dropColumn('lead_officer');
        });
    }
}
