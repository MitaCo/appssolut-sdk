<?php

class Myapp_Insert_New_Type {

	public function up()
	{
        // "type" must be same name as the type partial
        // "name" is used in drag and drop sidebar
        DB::query("insert into types (id, type, name, created_at, updated_at) values (22, 'mytype-paragraph', 'My Type Paragraph', '2013-06-10 12:00:00', '2013-06-10 12:00:00');");

        // Set new id sequence
        DB::query("SELECT setval('types_id_seq', 22);");
	}

	public function down()
	{
        DB::query("delete from types where id = 22");

        // Put back old id sequence
        DB::query("SELECT setval('types_id_seq', 21);");
	}

}