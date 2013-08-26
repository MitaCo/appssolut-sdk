<?php

class Add_Foreign_Keys_To_Targets {

	public function up()
	{
		Schema::table('targets', function($table) {
            $table->foreign('instance_id')->references('id')->on('instances')->on_update('cascade')->on_delete('cascade');
            $table->foreign('age_id')->references('id')->on('ages')->on_update('cascade')->on_delete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->on_update('cascade')->on_delete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->on_update('cascade')->on_delete('cascade');
		});
	}

	public function down()
	{
        DB::query('TRUNCATE TABLE targets CASCADE');
		Schema::table('targets', function($table) {
            $table->drop_foreign('targets_instance_id_foreign');
            $table->drop_foreign('targets_age_id_foreign');
            $table->drop_foreign('targets_country_id_foreign');
            $table->drop_foreign('targets_language_id_foreign');
		});
	}

}