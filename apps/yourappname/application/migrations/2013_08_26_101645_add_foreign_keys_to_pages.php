<?php

class Add_Foreign_Keys_To_Pages {

	public function up()
	{
		Schema::table('to_pages', function($table) 
{


		});
	}

	public function down()
	{
		Schema::table('to_pages', function($table) {
			$table->drop_column(array());
		});
	}

}