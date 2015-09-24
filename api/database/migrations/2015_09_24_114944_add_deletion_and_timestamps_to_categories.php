<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeletionAndTimestampsToCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table)
        {
            $table->softDeletes();
            $table->string('created_by', 255)->nullable();
            $table->string('updated_by', 255)->nullable();
            $table->timestamps();
        });

        $sql = 'update `categories` set `deleted_at`=now() where `is_passive` = 1';
        DB::connection()->getPdo()->exec($sql);

        $sql2 = 'update `categories` set `created_at`=now(), `updated_at`=now(), `created_by`="System", `updated_by`="System"';
        DB::connection()->getPdo()->exec($sql2);

        Schema::table('categories', function (Blueprint $table)
        {
            $table->dropColumn('is_passive');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table)
        {
            $table->boolean('is_passive')->default(false)->nullable();
        });

        $sql = 'update `categories` set `is_passive`=1 where `deleted_at` is not null';
        DB::connection()->getPdo()->exec($sql);

        Schema::table('categories', function (Blueprint $table)
        {
            $table->dropColumn('deleted_at');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }
}
