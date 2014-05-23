<?php
 
class PractitionerTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('practitioners')->truncate();
 
        Practitioner::create(array(
            'person' => 'Jostein Skaar',
            'email' => 'jostein.skaar@miljodir.no'
        ));

        Practitioner::create(array(
            'person' => 'Christian Haugland',
            'email' => 'christian.haugland@miljodir.no'
        ));

    }

}