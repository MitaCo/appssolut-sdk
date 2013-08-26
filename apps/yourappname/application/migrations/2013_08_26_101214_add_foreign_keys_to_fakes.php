<?php

class Add_Foreign_Keys_To_Fakes {

	public function up()
	{
		Schema::table('fakes', function($table) {
            $table->foreign('type_id')->references('id')->on('types')->on_update('cascade')->on_delete('cascade');
		});
	}

	public function down()
	{
        DB::query('TRUNCATE TABLE fakes CASCADE');
		Schema::table('fakes', function($table) {
            $table->drop_foreign('fakes_type_id_foreign');
		});
	}

}