<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizationDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cotization_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cotization_id')->unsigned();
			$table->integer('product_id')->unsigned();
			$table->double('quantity')->default(0)->nullable();
			$table->double('price')->default(0)->nullable();
			$table->double('total')->default(0)->nullable();
			$table->timestamps();

			$table->foreign('cotization_id')->references('id')->on('cotizations')->onDelete('cascade');
			$table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cotization_details');
	}

}
