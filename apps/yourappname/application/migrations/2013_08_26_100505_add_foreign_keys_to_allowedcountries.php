<?php

class Add_Foreign_Keys_To_Allowedcountries {

	public function up()
	{
		Schema::table('allowedcountries', function($table) {
            $table->foreign('instance_id')->references('id')->on('instances')->on_update('cascade')->on_delete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->on_update('cascade')->on_delete('cascade');
		});
	}

	public function down()
	{
        DB::query('TRUNCATE TABLE allowedcountries CASCADE');
		Schema::table('allowedcountries', function($table) {
            $table->drop_foreign('allowedcountries_instance_id_foreign');
            $table->drop_foreign('allowedcountries_country_id_foreign');
		});
	}

}