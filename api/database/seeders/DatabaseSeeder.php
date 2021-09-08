<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        // Eloquent::unguard();
        //DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //$this->call('ExcelDataTableSeeder');
        //DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // $this->call(TestUserSeeder::class);
        // Eloquent::reguard();
    }

}
