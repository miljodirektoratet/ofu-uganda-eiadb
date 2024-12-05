<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UniqueEmailAndInitialsInUsers extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('users', function(Blueprint $table)
    {
      $table->unique('initials');
      $table->unique('email');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('users', function($table)
    {
      $table->dropUnique('users_initials_unique');
      $table->dropUnique('users_email_unique');
    });
  }

}
