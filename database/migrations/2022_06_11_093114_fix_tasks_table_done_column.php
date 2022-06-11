<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
		// update messed data
	    DB::statement("UPDATE tasks SET done = 0 WHERE done = 'false'");
		// hurry hurry mistakes mistakes
        Schema::table('tasks', function(Blueprint $table) {
			$table->boolean('done')->default(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    DB::statement("UPDATE tasks SET done = 'false' WHERE done = 0");
	    Schema::table('tasks', function(Blueprint $table) {
		    $table->boolean('done')->default('false')->change();
	    });
    }
};
