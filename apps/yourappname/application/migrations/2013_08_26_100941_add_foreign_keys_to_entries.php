<?php

class Add_Foreign_Keys_To_Entries {

	public function up()
	{
		Schema::table('entries', function($table) {
            $table->foreign('instance_id')->references('id')->on('instances')->on_update('cascade')->on_delete('cascade');
            $table->foreign('page_id')->references('id')->on('pages')->on_update('cascade')->on_delete('cascade');
		});
	}

	public function down()
	{
        DB::query('TRUNCATE TABLE entries CASCADE');
		Schema::table('entries', function($table) {
            $table->drop_foreign('entries_instance_id_foreign');
            $table->drop_foreign('entries_page_id_foreign');
		});
	}

}