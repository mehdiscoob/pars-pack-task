<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('apps', function(Blueprint $table) {
			$table->foreign('platform_id')->references('id')->on('platforms')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('subscriptions', function(Blueprint $table) {
			$table->foreign('app_id')->references('id')->on('apps')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('subscriptions', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::table('apps', function(Blueprint $table) {
			$table->dropForeign('apps_platform_id_foreign');
		});
		Schema::table('subscriptions', function(Blueprint $table) {
			$table->dropForeign('subscriptions_app_id_foreign');
		});
		Schema::table('subscriptions', function(Blueprint $table) {
			$table->dropForeign('subscriptions_user_id_foreign');
		});
	}
}