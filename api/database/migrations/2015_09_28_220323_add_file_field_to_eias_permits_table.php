<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFileFieldToEiasPermitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eias_permits', function (Blueprint $table)
        {
            $table->integer('file_metadata_id')->unsigned()->nullable()->after('remarks');
            $table->foreign('file_metadata_id')->references('id')->on('file_metadata');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eias_permits', function (Blueprint $table)
        {
            $table->dropForeign('eias_permits_file_metadata_id_foreign');
            $table->dropColumn('file_metadata_id');
        });
    }
}
