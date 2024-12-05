<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerForPractisionerTestEmail extends Migration
{
      /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(config('app.env') == 'test') {

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `mutate_email_insert_practitioner`');
        DB::unprepared('DROP TRIGGER `mutate_email_update_practitioner`');
    }
}
