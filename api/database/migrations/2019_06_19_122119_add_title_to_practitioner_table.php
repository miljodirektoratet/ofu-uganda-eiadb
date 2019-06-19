<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTitleToPractitionerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('practitioners', function (Blueprint $table) {
            $table->integer('practitioner_title_id')->unsigned()->nullable()->after('id');
            $table->foreign('practitioner_title_id')->references('id')->on('codes');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('practitioners', function (Blueprint $table) {
            $table->dropColumn('title');
        });

    }
}
