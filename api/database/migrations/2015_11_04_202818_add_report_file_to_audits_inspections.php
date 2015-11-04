<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReportFileToAuditsInspections extends Migration
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
            $table->integer('file_metadata_report_id')->unsigned()->nullable()->after('file_metadata_id');
            $table->foreign('file_metadata_report_id')->references('id')->on('file_metadata');
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
            $table->dropForeign('audits_inspections_file_metadata_report_id_foreign');
            $table->dropColumn('file_metadata_report_id');
        });
    }
}
