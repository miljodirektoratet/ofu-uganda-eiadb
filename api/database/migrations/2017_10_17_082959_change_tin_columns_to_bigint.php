<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTinColumnsToBigint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organisations', function (Blueprint $table) {
               $table->bigInteger('tin')->unsigned()->nullable()->change();
        });

        Schema::table('practitioners', function (Blueprint $table) {
            $table->bigInteger('tin')->unsigned()->nullable()->change();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organisations', function (Blueprint $table) {
            $table->integer('tin')->unsigned()->nullable()->change();
        });

        Schema::table('practitioners', function (Blueprint $table) {
            $table->integer('tin')->unsigned()->nullable()->change();
        });
    }
}
