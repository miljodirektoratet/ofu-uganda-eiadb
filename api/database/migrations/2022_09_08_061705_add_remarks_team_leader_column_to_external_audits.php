<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRemarksTeamLeaderColumnToExternalAudits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('external_audits', function (Blueprint $table) {
            $table->text('remarks_team_leader')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('external_audits', function (Blueprint $table) {
            $table->dropColumn('remarks_team_leader');
        });
    }
}
