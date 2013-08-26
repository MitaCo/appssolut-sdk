<?php

class Create_Allowedcountries_Table {

	public function up()
	{
		Schema::create('allowedcountries', function($table) {
            $table->increments('id');
            $table->integer('instance_id');
            $table->integer('country_id');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('allowedcountries');
	}

}