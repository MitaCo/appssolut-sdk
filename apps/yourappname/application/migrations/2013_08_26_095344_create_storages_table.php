<?php

class Create_Storages_Table {

	public function up()
	{
		Schema::create('storages', function($table) {
            $table->increments('id');
            $table->integer('entry_id');
            $table->integer('field_id');
            $table->string('label', 64);
            $table->text('value')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('storages');
	}

}