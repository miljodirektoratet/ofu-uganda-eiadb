<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFieldsFromAauditsInspections extends Migration
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
            $table->dropColumn('timeframe');
            $table->dropColumn('date_received');
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
            $table->integer('timeframe')->unsigned()->nullable();
            $table->date('date_received')->nullable();
        });
    }
}
