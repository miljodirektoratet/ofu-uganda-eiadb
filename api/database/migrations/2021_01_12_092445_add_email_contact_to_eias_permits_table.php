<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailContactToEiasPermitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eias_permits', function (Blueprint $table) {
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
        Schema::table('eias_permits', function (Blueprint $table) {
            $table->dropColumn('email_contact');
        });
    }
}
