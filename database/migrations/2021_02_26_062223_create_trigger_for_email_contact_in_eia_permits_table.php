<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerForEmailContactInEiaPermitsTable extends Migration
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
        DB::unprepared('DROP TRIGGER `mutate_email_contact_insert_eia_permits`');
        DB::unprepared('DROP TRIGGER `mutate_email_contact_update_eias_permits`');
    }
}
