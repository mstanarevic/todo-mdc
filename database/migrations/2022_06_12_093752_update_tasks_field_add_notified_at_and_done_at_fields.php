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
        Schema::table('tasks', function(Blueprint $table) {
			$table->timestamp('done_at')->nullable();
			$table->timestamp('notified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('tasks', function(Blueprint $table) {
		    $table->dropColumn('done_at');
		    $table->dropColumn('notified_at');
	    });
    }
};
