<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropGradeColumnFromProjects extends Migration
{
   
      public function up()
      {
          Schema::table('projects', function($table) {
             $table->dropColumn('grade');
          });
      }

      public function down()
      {
          Schema::table('projects', function($table) {
             $table->string('grade')->nullable();
          });
      }
  
    
}
