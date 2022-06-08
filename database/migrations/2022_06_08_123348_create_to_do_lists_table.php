<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('to_do_lists', function (Blueprint $table) {
			$table->id();
			$table->string('title');
			$table->string('description');
			$table->date('date');
			$table->bigInteger('user_id')->unsigned();
			$table->timestamps();
		});

		Schema::table('to_do_lists', function (Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('to_do_lists');
	}
};
