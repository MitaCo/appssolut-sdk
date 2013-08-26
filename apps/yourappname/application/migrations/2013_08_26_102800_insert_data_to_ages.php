<?php

class Insert_Data_To_Ages {

	public function up()
	{
        DB::query("insert into ages (id, value, name, created_at, updated_at) values (1, 13, 'All', '2013-07-29 12:00:00', '2013-07-29 12:00:00');");
		DB::query("insert into ages (id, value, name, created_at, updated_at) values (2, 18, '18+', '2013-07-29 12:00:00', '2013-07-29 12:00:00');");
        DB::query("insert into ages (id, value, name, created_at, updated_at) values (3, 21, '21+', '2013-07-29 12:00:00', '2013-07-29 12:00:00');");

        DB::query("SELECT setval('ages_id_seq', 3);");
	}

	public function down()
	{
        //
	}

}