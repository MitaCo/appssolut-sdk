<?php

class Add_Foreign_Keys_To_Storages {

	public function up()
	{
		Schema::table('storages', function($table) {
            $table->foreign('entry_id')->references('id')->on('entries')->on_update('cascade')->on_delete('cascade');
            $table->foreign('field_id')->references('id')->on('fields')->on_update('cascade')->on_delete('cascade');
		});
	}

	public function down()
	{
        DB::query('TRUNCATE TABLE storages CASCADE');
		Schema::table('storages', function($table) {
            $table->drop_foreign('storages_entry_id_foreign');
            $table->drop_foreign('storages_field_id_foreign');
		});
	}

}