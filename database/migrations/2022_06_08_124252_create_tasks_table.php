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
	    Schema::create( 'tasks', function ( Blueprint $table ) {
		    $table->id();
		    $table->string( 'title' );
		    $table->string( 'description' );
		    $table->timestamp( 'deadline' );
		    $table->boolean( 'done' )->default( 'false' );
		    $table->bigInteger( 'to_do_list_id' )->unsigned();
		    $table->timestamps();
	    } );

	    Schema::table( 'tasks', function ( Blueprint $table ) {
		    $table->foreign( 'to_do_list_id' )->references( 'id' )->on( 'to_do_lists' );
	    } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
