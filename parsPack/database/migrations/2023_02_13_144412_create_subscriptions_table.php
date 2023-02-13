<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubscriptionsTable extends Migration {

	public function up()
	{
		Schema::create('subscriptions', function(Blueprint $table) {
			$table->increments('id')->primary();
			$table->enum('status', array('pending', 'active', 'expired'))->default("pending");
			$table->integer('app_id')->unsigned();
			$table->integer('user_id')->unsigned()->index();
			$table->timestamps();
			$table->softDeletes();
			$table->string('token', 300);
			$table->timestamp('repeat_time');
		});
	}

	public function down()
	{
		Schema::drop('subscriptions');
	}
}
