<?php

class Create_Templates_Table {

	public function up()
	{
		Schema::create('templates', function($table) {
            $table->increments('id');
            $table->string('name');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('templates');
	}

}