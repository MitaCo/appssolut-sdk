<?php

class Create_Invites_Table {

	public function up()
	{
		Schema::create('invites', function($table) {
            $table->increments('id');
            $table->integer('instance_id');
            $table->integer('request_id');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('invites');
	}

}