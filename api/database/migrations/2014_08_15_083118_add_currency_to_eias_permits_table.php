<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCurrencyToEiasPermitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('eias_permits', function(Blueprint $table)
		{
			$table->integer('cost_currency')->unsigned()->nullable()->after('cost');
			$table->integer('fee_currency')->unsigned()->nullable()->after('fee');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('eias_permits', function(Blueprint $table)
		{
			$table->dropColumn('cost_currency');
			$table->dropColumn('fee_currency');
		});
	}

}
