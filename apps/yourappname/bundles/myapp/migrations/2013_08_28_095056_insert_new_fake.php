<?php

class Myapp_Insert_New_Fake {

	public function up()
	{
        // "label" is used in the application field list
        // "value" is displayed to the end-user
        // "info" is text for the application field popover
        DB::query("
            insert into fakes (id, type_id, template_id, page_id, label, value, info, position, required, button, property, created_at, updated_at)
            values (18, 22, 1,  3, 'My Type', 'This is the default value for mytype-paragraph.', 'The type depends on what is inside its partial view.', 4, 1, null, null, '2013-06-10 12:00:00', '2013-06-10 12:00:00');
        ");

        DB::query("SELECT setval('fakes_id_seq', 18);");
	}

	public function down()
	{
        DB::query("delete from fakes where id = 18");

        DB::query("SELECT setval('fakes_id_seq', 17);");
	}

}