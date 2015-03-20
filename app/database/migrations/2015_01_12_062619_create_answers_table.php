<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('answers', function(Blueprint $table)
		{
			//
			$table->increments('id');
			$table->text("content");
			$table->integer("votes")->default(0);
			$table->enum("correct", array("0" ,"1"))->default(0);
			$table->integer("userID")->unsigned()->default(0);
			$table->integer("questionID")->unsigned()->default(0);
			$table->foreign("userID")->references("id")->on("users")->onDelte("cascade");
			$table->foreign("questionID")->references("id")->on("questions")->onDelte("cascade");
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
		Schema::drop('answers', function(Blueprint $table)
		{
			//
		});
	}

}
