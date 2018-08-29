<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->datetime('payment_date');
			$table->decimal('amount', 12, 4)->default(0);
			$table->integer('payment_type_id')->unsigned();
			$table->boolean('active')->default(1);
			$table->datetime('cancel_date')->nullable();
			$table->text('comments')->nullable();
			$table->timestamps();

			$table->foreign('payment_type_id')->references('id')->on('payment_types')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('payments');
	}

}
