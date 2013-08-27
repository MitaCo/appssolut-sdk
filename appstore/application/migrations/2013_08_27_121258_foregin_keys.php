<?php

class Foregin_Keys {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('app_user_apps_publishes', function($table) {
            $table->foreign('app_apps_application_id')->references('id')->on('app_apps_applications')->on_update('cascade')->on_delete('cascade');
            
		});
		Schema::table('app_apps_fbapps', function($table) {
            $table->foreign('app_apps_application_id')->references('id')->on('app_apps_applications')->on_update('cascade')->on_delete('cascade');
            
		});
	}

	public function down()
	{
        
		Schema::table('app_user_apps_publishes', function($table) {
            $table->drop_foreign('app_user_apps_publishes_app_apps_application_id_foreign');
		});
		Schema::table('app_apps_fbapps', function($table) {
            $table->drop_foreign('app_apps_fbapps_app_apps_application_id_foreign');
		});
	}

}