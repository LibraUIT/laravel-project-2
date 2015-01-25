<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questions', function(Blueprint $table)
		{
			//
			$table->increments('id');
			$table->string('title', 255);
			$table->text('content');
			$table->integer("viewed")->unsigned()->default(0);
			$table->integer("votes")->default(0);
			$table->integer('categorieID')->unsigned()->default(0);
			$table->integer('userID')->unsigned()->default(0);
			$table->foreign("userID")->references("id")->on("users")->onDelete("cascade");
			$table->foreign("categorieID")->references("id")->on("categories")->onDelete("cascade");
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
		Schema::drop("questions");
	}

}
