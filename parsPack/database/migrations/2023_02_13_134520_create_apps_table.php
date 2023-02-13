<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAppsTable extends Migration {

	public function up()
	{
		Schema::create('apps', function(Blueprint $table) {
			$table->increments('id')->primary();
			$table->string('name', 200)->default('null');
			$table->integer('platform_id')->unsigned()->index();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('apps');
	}
}
