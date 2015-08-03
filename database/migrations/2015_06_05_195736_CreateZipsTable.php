<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateZipsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('zips', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->char('zip_code', 5)->index('zip_code');
			$table->float('lat', 10, 0);
			$table->float('lon', 10, 0);
			$table->string('city', 100);
			$table->string('state_prefix', 100);
			$table->string('county', 100);
			$table->string('country', 100);
		});

		\DB::unprepared(File::get(database_path().'/raw/zip_code.sql'));

	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('zips');
	}

}
