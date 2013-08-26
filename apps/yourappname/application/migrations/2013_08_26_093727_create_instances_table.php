<?php

class Create_Instances_Table {

	public function up()
	{
		Schema::create('instances', function($table) {
            $table->increments('id');
            $table->string('instance', 32);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('instances');
	}

}