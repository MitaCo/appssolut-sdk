<?php

class Insert_Data_To_Types {

	public function up()
	{
        DB::query("insert into types (id, type, created_at, updated_at, name) values (1, 'header-banner', '2013-06-10 12:00:00', '2013-06-10 12:00:00', 'Header banner');");
        DB::query("insert into types (id, type, created_at, updated_at, name) values (2, 'text-header-2', '2013-06-10 12:00:00', '2013-06-10 12:00:00', 'Main title');");
        DB::query("insert into types (id, type, created_at, updated_at, name) values (3, 'text-header-3', '2013-06-10 12:00:00', '2013-06-10 12:00:00', 'Subtitle');");
        DB::query("insert into types (id, type, created_at, updated_at, name) values (4, 'text-paragraph', '2013-06-10 12:00:00', '2013-06-10 12:00:00', 'Text');");
        DB::query("insert into types (id, type, created_at, updated_at, name) values (6, 'input-string', '2013-06-10 12:00:00', '2013-06-10 12:00:00', 'Information box');");
        DB::query("insert into types (id, type, created_at, updated_at, name) values (7, 'input-number', '2013-06-10 12:00:00', '2013-06-10 12:00:00', 'Number box');");
        DB::query("insert into types (id, type, created_at, updated_at, name) values (8, 'input-email', '2013-06-10 12:00:00', '2013-06-10 12:00:00', 'Email box');");
        DB::query("insert into types (id, type, created_at, updated_at, name) values (9, 'input-url', '2013-06-10 12:00:00', '2013-06-10 12:00:00', 'Url box');");
        DB::query("insert into types (id, type, created_at, updated_at, name) values (10, 'input-date', '2013-06-10 12:00:00', '2013-06-10 12:00:00', 'Date box');");
        DB::query("insert into types (id, type, created_at, updated_at, name) values (11, 'input-phone', '2013-06-10 12:00:00', '2013-06-10 12:00:00', 'Enter phone No. box');");
        DB::query("insert into types (id, type, created_at, updated_at, name) values (12, 'input-checkbox', '2013-06-10 12:00:00', '2013-06-10 12:00:00', 'Check box');");
        DB::query("insert into types (id, type, created_at, updated_at, name) values (13, 'input-country', '2013-06-10 12:00:00', '2013-06-10 12:00:00', 'Select country box');");
        DB::query("insert into types (id, type, created_at, updated_at, name) values (14, 'input-state-us', '2013-06-10 12:00:00', '2013-06-10 12:00:00', 'Select state box');");
        DB::query("insert into types (id, type, created_at, updated_at, name) values (15, 'input-salutation', '2013-06-10 12:00:00', '2013-06-10 12:00:00', 'Select title (Mr./Mrs.) box');");
        DB::query("insert into types (id, type, created_at, updated_at, name) values (16, 'input-gender', '2013-06-10 12:00:00', '2013-06-10 12:00:00', 'Select gender box');");
        DB::query("insert into types (id, type, created_at, updated_at, name) values (17, 'input-textarea', '2013-06-10 12:00:00', '2013-06-10 12:00:00', 'Text box');");
        DB::query("insert into types (id, type, created_at, updated_at, name) values (18, 'submit-button', '2013-06-10 12:00:00', '2013-06-10 12:00:00', 'Submit button');");
        DB::query("insert into types (id, type, created_at, updated_at, name) values (19, 'input-accept-privacy', '2013-06-10 12:00:00', '2013-06-10 12:00:00', 'Accept privacy');");
        DB::query("insert into types (id, type, created_at, updated_at, name) values (20, 'input-accept-terms', '2013-06-10 12:00:00', '2013-06-10 12:00:00', 'Accept terms');");
        DB::query("insert into types (id, type, created_at, updated_at, name) values (21, 'input-accept-rules', '2013-06-10 12:00:00', '2013-06-10 12:00:00', 'Accept rules');");

        DB::query("SELECT setval('types_id_seq', 21);");
    }

	public function down()
	{
		//
	}

}