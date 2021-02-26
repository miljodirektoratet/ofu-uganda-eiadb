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

            DB::unprepared("
            CREATE TRIGGER `mutate_email_contact_insert_eia_permits` BEFORE INSERT ON `eias_permits`
            FOR EACH ROW 
            BEGIN
            SET NEW.email_contact = REGEXP_REPLACE(REGEXP_REPLACE(NEW.email_contact,'@([^;]*);','@nema.gdpr;'), '@([^;]*)$','@nema.gdpr');
            END
            ");

            DB::unprepared("
            CREATE TRIGGER `mutate_email_contact_update_eias_permits` BEFORE UPDATE ON `eias_permits`
            FOR EACH ROW 
            BEGIN
            SET NEW.email_contact =  REGEXP_REPLACE(REGEXP_REPLACE(NEW.email_contact,'@([^;]*);','@nema.gdpr;'), '@([^;]*)$','@nema.gdpr');
            END
            ");

            DB::table('eias_permits')->update(['updated_by'=>'system']);
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
