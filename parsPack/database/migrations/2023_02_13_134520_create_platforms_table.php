<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlatformsTable extends Migration {

	public function up()
	{
		Schema::create('platforms', function(Blueprint $table) {
            $table->id();
			$table->string('name', 200)->default('null');
			$table->integer('duration')->default(0);
			$table->timestamps();
			$table->softDeletes();
		});
        // Insert some stuff
        DB::table('platforms')->insert(
            array(
                'name' => 'Google',
                'duration' => 3600
            )
        );
        DB::table('platforms')->insert(
            array(
                'name' => 'Apple',
                'duration' => 7200
            )
        );

	}

	public function down()
	{
		Schema::drop('platforms');
	}
}
