<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteStatuses extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::drop('statuses');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::create('statuses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 25);
			$table->string('type', 20);
			$table->boolean('is_default')->default(0);
			$table->boolean('is_final')->default(0);
			$table->timestamps();
		});
	}

}
