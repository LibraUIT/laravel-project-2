<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePdfsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pdfs', function(Blueprint $table)
		{
			//
			$table->increments('id');
			$table->text("data");
			$table->string('name', 255);
			$table->string('title', 255);
			$table->integer("userID")->unsigned()->default(0);
			$table->foreign("userID")->references("id")->on("users")->onDelte("cascade");
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
		Schema::drop('pdfs', function(Blueprint $table)
		{
			//
		});
	}

}
