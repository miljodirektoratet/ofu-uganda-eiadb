<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileMetadataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_metadata', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('filename', 255);
            $table->string('storage_filename', 255)->unique();
            $table->string('extension', 10);
            $table->string('mime', 255);
            $table->integer('size_bytes')->unsigned();
            $table->string('size_human_readable', 50);
            $table->softDeletes();
            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('file_metadata');
    }
}
