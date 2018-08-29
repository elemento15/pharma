<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeStatusToPurchaseOrder extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('purchase_orders', function(Blueprint $table)
		{
			// delete "status_id" field
			$table->dropForeign('purchase_orders_status_id_foreign');
			$table->dropColumn('status_id');

			// add new status "field"
			$table->enum('status', ['N', 'P', 'C'])->default('N')->after('total');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('purchase_orders', function(Blueprint $table)
		{
			$table->integer('status_id')->unsigned()->nullable()->after('total');
			$table->foreign('status_id')->references('id')->on('statuses')->onDelete('restrict');

			$table->dropColumn('status');
		});
	}

}
