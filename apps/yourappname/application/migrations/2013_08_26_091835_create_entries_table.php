<?php

class Create_Entries_Table {

	public function up()
	{
		Schema::create('entries', function($table) {
			$table->increments('id');
            $table->integer('instance_id');
            $table->integer('page_id');
            $table->integer('target_id');
            $table->string('uid', 64);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('entries');
	}

}