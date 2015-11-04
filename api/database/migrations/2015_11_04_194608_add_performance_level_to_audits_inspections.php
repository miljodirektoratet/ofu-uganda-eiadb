<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPerformanceLevelToAuditsInspections extends Migration
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
            $table->integer('performance_level')->unsigned()->nullable()->after('lead_officer');
        });

        $sql = 'update `audits_inspections` set `performance_level`=47 where `performance_level` is null';
        DB::connection()->getPdo()->exec($sql);
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
            $table->dropColumn('performance_level');
        });
    }
}
