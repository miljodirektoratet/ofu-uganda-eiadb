<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCostOfTheProposedDevelopmentToBigint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eias_permits', function (Blueprint $table) {
            $table->bigInteger('cost')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eias_permits', function (Blueprint $table) {
            $table->integer('cost')->unsigned()->nullable()->change();
        });
    }
}
