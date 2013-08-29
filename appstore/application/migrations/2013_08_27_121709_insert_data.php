<?php

class Insert_Data {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		DB::query("insert into app_apps_applications (id, app_nicename, app_folder, created_at, updated_at) values (1, 'My First Application', 'yourappname', '2013-06-10 12:00:00', '2013-06-10 12:00:00');");
        DB::query("insert into app_apps_fbapps (id, fbappid, fbsecret, fbnamespace, app_apps_application_id, created_at, updated_at) 
        	values (1, 'fbkey', 'fbsecret', '01', 1, '2013-06-10 12:00:00', '2013-06-10 12:00:00');");
        
        // insert 3 instance apps to test
        DB::query("insert into app_user_apps_publishes (id, status, app_user_apps_publish_page_id, app_apps_fbapp_id, app_apps_application_id, created_at, updated_at) 
        	values 
        	(1, 'A', '0001', NULL, 1, '2013-06-10 12:00:00', '2013-06-10 12:00:00'),
        	(2, 'A', '0002', 1, 1, '2013-06-10 12:00:00', '2013-06-10 12:00:00'),
        	(3, 'A', '0003', NULL, 1, '2013-06-10 12:00:00', '2013-06-10 12:00:00')
        	;");
        
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		DB::query('TRUNCATE TABLE app_user_apps_publishes CASCADE');
		DB::query('TRUNCATE TABLE app_apps_fbapps CASCADE');
		DB::query('TRUNCATE TABLE app_apps_applications CASCADE');
	}

}