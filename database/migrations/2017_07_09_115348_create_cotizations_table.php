<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cotizations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('customer_id')->unsigned();
			$table->datetime('cotization_date');
			$table->double('total')->default(0);
			$table->integer('status_id')->unsigned()->nullable();
			$table->boolean('active')->default(1);
			$table->text('comments')->nullable();
			$table->timestamps();

			$table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict');
			$table->foreign('status_id')->references('id')->on('statuses')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cotizations');
	}

}
