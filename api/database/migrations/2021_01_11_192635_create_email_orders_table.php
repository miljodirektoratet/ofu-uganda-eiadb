<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('foreign_id')->unsigned()->nullable();
            $table->string('foreign_type', 10);
            $table->integer('order_status')->unsigned()->default(1);
            $table->string('subject', 255);
            $table->string('body', 3000);
            $table->string('recipient', 255);
            $table->string('cc', 255)->nullable();
            $table->string('bcc', 255)->nullable();
            $table->string('remarks_from_service', 2000)->nullable();
            $table->string('remarks', 2000)->nullable();
            $table->integer('number_of_attempts')->unsigned()->default(0);
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('updated_by', 255)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('email_orders');
    }
}
