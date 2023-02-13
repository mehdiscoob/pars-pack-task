<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubscriptionsTable extends Migration {

	public function up()
	{
		Schema::create('subscriptions', function(Blueprint $table) {
            $table->id();
			$table->enum('status', array('pending', 'active', 'expired'))->default("pending");
			$table->unsignedBigInteger('app_id');
			$table->unsignedBigInteger('user_id')->index();
			$table->timestamps();
			$table->softDeletes();
			$table->string('token', 300);
			$table->timestamp('repeat_time')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('subscriptions');
	}
}
