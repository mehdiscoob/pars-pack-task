<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAppsTable extends Migration {

	public function up()
	{
		Schema::create('apps', function(Blueprint $table) {
			$table->id();
			$table->string('name', 200)->default('null');
			$table->unsignedBigInteger('platform_id')->index();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('apps');
	}
}
