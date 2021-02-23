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

            DB::unprepared("
            CREATE TRIGGER `mutate_email_insert_practitioner` BEFORE INSERT ON `practitioners`
            FOR EACH ROW 
            BEGIN
            SET NEW.email = CONCAT(REPLACE(REPLACE(TRIM(TRAILING '.nema.gdpr' FROM NEW.email ), '.nema.gdpr;', ';'), ';', '.nema.gdpr;'), '.', 'nema.gdpr');
            END
            ");

            DB::unprepared("
            CREATE TRIGGER `mutate_email_update_practitioner` BEFORE UPDATE ON `practitioners`
            FOR EACH ROW 
            BEGIN
            SET NEW.email =  CONCAT(REPLACE(REPLACE(TRIM(TRAILING '.nema.gdpr' FROM NEW.email ), '.nema.gdpr;', ';'), ';', '.nema.gdpr;'), '.', 'nema.gdpr');
            END
            ");

            DB::table('practitioners')->update(['updated_by'=>'system']);
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
