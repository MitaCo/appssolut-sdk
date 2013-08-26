<?php

class Add_Foreign_Keys_To_Invites {

	public function up()
	{
		Schema::table('invites', function($table) {
            $table->foreign('instance_id')->references('id')->on('instances')->on_update('cascade')->on_delete('cascade');
		});
	}

	public function down()
	{
        DB::query('TRUNCATE TABLE invites CASCADE');
		Schema::table('invites', function($table) {
            $table->drop_foreign('invites_instance_id_foreign');
		});
	}

}