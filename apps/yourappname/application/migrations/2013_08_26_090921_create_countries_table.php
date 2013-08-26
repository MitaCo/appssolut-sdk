<?php

class Create_Countries_Table {

	public function up()
	{
		Schema::create('countries', function($table) {
            $table->increments('id');
            $table->string('code', 8);
            $table->string('name', 64);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('countries');
	}

}