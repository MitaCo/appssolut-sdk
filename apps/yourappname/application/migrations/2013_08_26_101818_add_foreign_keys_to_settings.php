<?php

class Add_Foreign_Keys_To_Settings {

	public function up()
	{
		Schema::table('settings', function($table) {
            $table->foreign('instance_id')->references('id')->on('instances')->on_update('cascade')->on_delete('cascade');
		});
	}

	public function down()
	{
        DB::query('TRUNCATE TABLE settings CASCADE');
		Schema::table('settings', function($table) {
            $table->drop_foreign('settings_instance_id_foreign');
		});
	}

}