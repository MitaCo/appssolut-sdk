<?php

class Insert_Data_To_Pages {

	public function up()
	{
        DB::query("insert into pages (id, name, image, created_at, updated_at) values (1, 'Fangate', 'fangate.jpg', '2013-05-06 13:10:00', '2013-05-06 13:10:00');");
        DB::query("insert into pages (id, name, image, created_at, updated_at) values (2, 'Entry Form', 'header.jpg', '2013-05-06 13:10:00', '2013-05-06 13:10:00');");
        DB::query("insert into pages (id, name, image, created_at, updated_at) values (3, 'Application', 'header.jpg', '2013-05-06 13:10:00', '2013-05-06 13:10:00');");

        DB::query("SELECT setval('pages_id_seq', 3);");
	}

	public function down()
	{
		//
	}

}