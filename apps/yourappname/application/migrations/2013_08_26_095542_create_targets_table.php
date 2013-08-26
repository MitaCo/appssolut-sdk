<?php

class Create_Targets_Table {

	public function up()
	{
		Schema::create('targets', function($table) {
            $table->increments('id');
            $table->integer('instance_id');
            $table->integer('age_id');
            $table->integer('country_id');
            $table->integer('language_id');
            $table->string('title', 32);
            $table->boolean('active');
            $table->boolean('default');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('targets');
	}

}