<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetUnknownInInpsecitonRecomendedForEiasPermits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = 'update `eias_permits` set `inspection_recommended`=42 where `inspection_recommended` is null';
        DB::connection()->getPdo()->exec($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        print("inspection_recomended can't be rolled back.\n");
    }
}
