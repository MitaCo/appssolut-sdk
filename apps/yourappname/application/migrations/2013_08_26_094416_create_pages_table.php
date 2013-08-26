<?php

class Create_Pages_Table {

	public function up()
	{
		Schema::create('pages', function($table) {
            $table->increments('id');
            $table->string('name', 32);
            $table->boolean('visible')->default(1);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('pages');
	}

}