<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExpiredLogsTable extends Migration {

	public function up()
	{
		Schema::create('expired_logs', function(Blueprint $table) {
            $table->id();
			$table->integer('counter')->default(0);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('expired_logs');
	}
}
