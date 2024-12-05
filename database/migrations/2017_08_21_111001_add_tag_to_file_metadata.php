<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTagToFileMetadata extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('file_metadata', function (Blueprint $table) {
            $table->string('tag', 255)->nullable()->after('size_human_readable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('file_metadata', function (Blueprint $table) {
            $table->dropColumn('tag');
        });
    }
}
