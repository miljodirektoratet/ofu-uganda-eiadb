<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerForTestEmailUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(config('app.env') == 'test') {

            DB::unprepared("
            CREATE TRIGGER `mutate_email_insert` BEFORE INSERT ON `organisations`
            FOR EACH ROW 
            BEGIN
            SET NEW.email = REGEXP_REPLACE(REGEXP_REPLACE(NEW.email,'@([^;]*);','@nema.gdpr;'), '@([^;]*)$','@nema.gdpr');
            END
            ");

            DB::unprepared("
            CREATE TRIGGER `mutate_email_update` BEFORE UPDATE ON `organisations`
            FOR EACH ROW 
            BEGIN
            SET NEW.email = REGEXP_REPLACE(REGEXP_REPLACE(NEW.email,'@([^;]*);','@nema.gdpr;'), '@([^;]*)$','@nema.gdpr');
            END
            ");

            DB::table('organisations')->update(['updated_by'=>'system']);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `mutate_email_insert`');
        DB::unprepared('DROP TRIGGER `mutate_email_update`');
    }
}
