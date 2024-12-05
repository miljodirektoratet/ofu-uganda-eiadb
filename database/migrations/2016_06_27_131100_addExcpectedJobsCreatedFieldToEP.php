<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExcpectedJobsCreatedFieldToEP extends Migration
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
            $table->decimal('expected_jobs_created', 24, 6)->nullable()->after('cost_currency');
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
            $table->dropColumn('expected_jobs_created');
        });
    }
}
