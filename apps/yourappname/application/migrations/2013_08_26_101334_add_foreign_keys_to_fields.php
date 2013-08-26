<?php

class Add_Foreign_Keys_To_Fields {

	public function up()
	{
		Schema::table('fields', function($table) {
            $table->foreign('instance_id')->references('id')->on('instances')->on_update('cascade')->on_delete('cascade');
            $table->foreign('type_id')->references('id')->on('types')->on_update('cascade')->on_delete('cascade');
            $table->foreign('target_id')->references('id')->on('targets')->on_update('cascade')->on_delete('cascade');
            $table->foreign('page_id')->references('id')->on('pages')->on_update('cascade')->on_delete('cascade');
		});
	}

	public function down()
	{
        DB::query('TRUNCATE TABLE fields CASCADE');
		Schema::table('fields', function($table) {
            $table->drop_foreign('fields_instance_id_foreign');
            $table->drop_foreign('fields_type_id_foreign');
            $table->drop_foreign('fields_target_id_foreign');
            $table->drop_foreign('fields_page_id_foreign');
		});
	}

}