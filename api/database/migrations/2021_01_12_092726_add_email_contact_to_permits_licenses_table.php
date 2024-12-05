<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailContactToPermitsLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permits_licenses', function (Blueprint $table) {
            $table->string('email_contact', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permits_licenses', function (Blueprint $table) {
            $table->dropColumn('email_contact');
        });
    }
}
