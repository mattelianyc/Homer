<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrequentedLocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('frequented_locations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('temp_user_id');
			$table->foreign('temp_user_id')->references('payload')->on('temp_users');
			$table->string('address');
			$table->decimal('lat', 10, 8);
			$table->decimal('lng', 11, 8);
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
		//
	}

}
