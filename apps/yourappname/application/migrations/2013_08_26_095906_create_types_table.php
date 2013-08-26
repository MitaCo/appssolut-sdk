<?php

class Create_Types_Table {

	public function up()
	{
		Schema::create('types', function($table) {
            $table->increments('id');
            $table->string('type', 32);
            $table->string('name', 64);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('types');
	}

}