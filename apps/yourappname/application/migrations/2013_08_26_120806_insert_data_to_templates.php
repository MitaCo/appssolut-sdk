<?php

class Insert_Data_To_Templates {

	public function up()
	{
		DB::query("insert into templates (id, name, created_at, updated_at) values (1, 'Default', '2013-07-29 12:00:00', '2013-07-29 12:00:00');");

        DB::query("SELECT setval('templates_id_seq', 1);");
	}

	public function down()
	{
		//
	}

}