<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToPurchaseOrders extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('purchase_orders', function(Blueprint $table)
		{
			$table->double('subtotal')->default(0)->after('order_date');
			$table->double('iva_amount')->default(0)->after('subtotal');
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
			$table->dropColumn('subtotal');
			$table->dropColumn('iva_amount');
		});
	}

}
