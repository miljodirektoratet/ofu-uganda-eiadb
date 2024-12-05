<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFromEIAToEISInDocumentsCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = "update documents set code = REPLACE(code, 'EIA', 'EIS') where code rlike '^EIA[0-9]{1,10}';\n";
        $sql .= "update documents set code = REPLACE(code, 'eia', 'EIS') where code rlike '^EIA[0-9]{1,10}';";
        DB::connection()->getPdo()->exec($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        print("CHanging from EIA to EIS for documents code can't be rolled back.\n");
    }
}
