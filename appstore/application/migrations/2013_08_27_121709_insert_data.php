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

        /*
        $table->increments('id');
            $table->string('status')->nullable();
            $table->string('app_user_apps_publish_page_id');
            $table->integer('app_apps_fbapp_id')->default(1);
            $table->integer('app_apps_application_id')->default(1);
			$table->timestamps();
			*/
        DB::query("insert into app_user_apps_publishes (id, status, app_user_apps_publish_page_id, app_apps_fbapp_id, app_apps_application_id, created_at, updated_at) 
        	values 
        	(1, '', '123', NULL, 1, '2013-06-10 12:00:00', '2013-06-10 12:00:00'),
        	(2, 'A', '231', 1, 1, '2013-06-10 12:00:00', '2013-06-10 12:00:00'),
        	(3, '', '312', NULL, 1, '2013-06-10 12:00:00', '2013-06-10 12:00:00')
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