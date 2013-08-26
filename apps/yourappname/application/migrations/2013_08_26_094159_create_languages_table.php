<?php

class Create_Languages_Table {

	public function up()
	{
		Schema::create('languages', function($table) {
            $table->increments('id');
            $table->string('langcode', 8);
            $table->string('address_code', 8)->nullable();
            $table->string('name', 64);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('languages');
	}

}