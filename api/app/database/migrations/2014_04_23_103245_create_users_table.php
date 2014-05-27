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
			$table->string('initials', 255)->nullable();
			$table->string('full_name', 255)->nullable();
			$table->string('job_position_code', 255)->nullable();
			$table->integer('job_position_name')->unsigned()->nullable();
    	$table->string('email')->unique();        	
    	$table->string('password');
    	$table->string('remember_token');
    	$table->boolean('is_passive')->default(false)->nullable();
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
		Schema::dropIfExists('users', function(Blueprint $table)
		{
			//
		});
	}

}
