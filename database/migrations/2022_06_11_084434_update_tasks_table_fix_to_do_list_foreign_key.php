<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		// sqlite doesn't support foreign key dropping, we need to recreate whole table
		if(env('DB_CONNECTION') == 'sqlite') {
			// backup data @TODO - This might exhaust memory if we are talking large
			// numbers
			$data = DB::table('tasks')->get()->map(function($item) {
				return (array)$item;
			});
			// delete
			Schema::drop('tasks');
			Schema::create( 'tasks', function ( Blueprint $table ) {
				$table->id();
				$table->string( 'title' );
				$table->text( 'description' );
				$table->timestamp( 'deadline' );
				$table->boolean( 'done' )->default( 'false' );
				$table->bigInteger( 'to_do_list_id' )->unsigned();
				$table->timestamps();
				// fix foreign
				$table->foreign( 'to_do_list_id' )->references( 'id' )->on( 'to_do_lists' )->onDelete( 'cascade' );
			} );
			// restore data
			\Log::debug(print_r($data->toArray(), true));
			DB::table('tasks')->insert($data->toArray());
		} else {
			Schema::table( 'tasks', function ( Blueprint $table ) {
				$table->dropForeign( 'to_do_list_id' );
			} );
			// just in case two different transactions
			Schema::table('tasks', function (Blueprint $table) {
				$table->foreign( 'to_do_list_id' )->references( 'id' )->on( 'to_do_lists' )->onDelete( 'cascade' );
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		if(env('DB_CONNECTION') == 'sqlite') {
			// backup data @TODO - This might exhaust memory if we are talking large
			// numbers
			$data = DB::table('tasks')->get()->map(function($item) {
				return (array)$item;
			});;
			Schema::drop('tasks');
			Schema::create( 'tasks', function ( Blueprint $table ) {
				$table->id();
				$table->string( 'title' );
				$table->text( 'description' );
				$table->timestamp( 'deadline' );
				$table->boolean( 'done' )->default( 'false' );
				$table->bigInteger( 'to_do_list_id' )->unsigned();
				$table->timestamps();
				// fix foreign
				$table->foreign( 'to_do_list_id' )->references( 'id' )->on( 'to_do_lists' );
			} );
			// restore data
			DB::table('tasks')->insert($data->toArray());
		} else {
			Schema::table( 'tasks', function ( Blueprint $table ) {
				$table->dropForeign( 'to_do_list_id' );
			} );
			Schema::table( 'tasks', function ( Blueprint $table ) {
				$table->foreign( 'to_do_list_id' )->references( 'id' )->on( 'to_do_lists' );
			} );
		}

	}
};
