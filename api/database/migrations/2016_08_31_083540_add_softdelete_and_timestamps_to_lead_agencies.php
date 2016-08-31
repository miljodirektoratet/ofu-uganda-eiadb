<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftdeleteAndTimestampsToLeadAgencies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lead_agencies', function (Blueprint $table)
        {
            $table->softDeletes();
            $table->string('created_by', 255)->nullable()->default('SYSTEM');
            $table->string('updated_by', 255)->nullable()->default('SYSTEM');
//            $table->timestamps();
            $table->timestamp('created_at');//->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lead_agencies', function (Blueprint $table)
        {
            $table->dropColumn('deleted_at');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');

        });
    }
}
