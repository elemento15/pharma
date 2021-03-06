<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('rfc', 13)->unique()->nullable();
			$table->string('contact')->nullable();
			$table->string('phone', 20)->nullable();
			$table->string('mobile', 20)->nullable();
			$table->string('email')->nullable();
			$table->string('address')->nullable();
			$table->boolean('active')->default(1);
			$table->text('comments')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customers');
	}

}
