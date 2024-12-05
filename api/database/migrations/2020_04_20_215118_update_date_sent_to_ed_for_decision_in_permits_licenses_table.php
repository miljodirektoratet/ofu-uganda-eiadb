<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDateSentToEdForDecisionInPermitsLicensesTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permits_licenses', function (Blueprint $table)
        {
            $table->renameColumn('date_sent_to_ed_for_decision', 'date_sent_for_decision');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permits_licenses', function (Blueprint $table)
        {
            $table->renameColumn('date_sent_for_decision', 'date_sent_to_ed_for_decision');
        });
    }
}
