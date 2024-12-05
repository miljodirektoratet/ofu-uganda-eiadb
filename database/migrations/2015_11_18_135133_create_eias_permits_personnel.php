<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEiasPermitsPersonnel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eias_permits_personnel', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('eia_permit_id')->unsigned()->nullable();
            $table->foreign('eia_permit_id')->references('id')->on('eias_permits');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eias_permits_personnel', function(Blueprint $table){});
    }
}
