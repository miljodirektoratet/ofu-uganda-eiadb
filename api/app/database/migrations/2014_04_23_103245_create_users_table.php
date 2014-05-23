<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('initials', 10);
			$table->string('full_name', 100);
			$table->string('job_title', 100);
			$table->integer('job_position')->unsigned();
    	$table->string('email')->unique();        	
    	$table->string('password');
    	$table->string('remember_token');        	
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
		Schema::dropIfExists('users', function(Blueprint $table)
		{
			//
		});
	}

}
