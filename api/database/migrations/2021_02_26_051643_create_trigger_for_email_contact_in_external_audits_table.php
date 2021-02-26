<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerForEmailContactInExternalAuditsTable extends Migration
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
            CREATE TRIGGER `mutate_email_contact_insert_external_audit` BEFORE INSERT ON `external_audits`
            FOR EACH ROW 
            BEGIN
            SET NEW.email_contact = REGEXP_REPLACE(REGEXP_REPLACE(NEW.email_contact,'@([^;]*);','@nema.gdpr;'), '@([^;]*)$','@nema.gdpr');
            END
            ");

            DB::unprepared("
            CREATE TRIGGER `mutate_email_contact_update_external_audit` BEFORE UPDATE ON `external_audits`
            FOR EACH ROW 
            BEGIN
            SET NEW.email_contact =  REGEXP_REPLACE(REGEXP_REPLACE(NEW.email_contact,'@([^;]*);','@nema.gdpr;'), '@([^;]*)$','@nema.gdpr');
            END
            ");

            DB::table('external_audits')->update(['updated_by'=>'system']);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `mutate_email_contact_insert_external_audit`');
        DB::unprepared('DROP TRIGGER `mutate_email_contact_update_external_audit`');
    }
}
