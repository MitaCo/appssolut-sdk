<?php

class Create_Ages_Table {

	public function up()
	{
		Schema::create('ages', function($table) {
			$table->increments('id');
            $table->integer('value');
            $table->string('name', 64);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('ages');
	}

}