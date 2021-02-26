<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerForEmailContactInPermitLicenseTable extends Migration
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
            CREATE TRIGGER `mutate_email_contact_insert_ permits_licenses` BEFORE INSERT ON `permits_licenses`
            FOR EACH ROW 
            BEGIN
            SET NEW.email_contact = REGEXP_REPLACE(REGEXP_REPLACE(NEW.email_contact,'@([^;]*);','@nema.gdpr;'), '@([^;]*)$','@nema.gdpr');
            END
            ");

            DB::unprepared("
            CREATE TRIGGER `mutate_email_contact_update_ permits_licenses` BEFORE UPDATE ON `permits_licenses`
            FOR EACH ROW 
            BEGIN
            SET NEW.email_contact =  REGEXP_REPLACE(REGEXP_REPLACE(NEW.email_contact,'@([^;]*);','@nema.gdpr;'), '@([^;]*)$','@nema.gdpr');
            END
            ");

            DB::table('permits_licenses')->update(['updated_by'=>'system']);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `mutate_email_contact_insert_ permits_licenses`');
        DB::unprepared('DROP TRIGGER `mutate_email_contact_update_ permits_licenses`');
    }
}
