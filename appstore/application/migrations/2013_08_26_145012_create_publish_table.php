<?php

class Create_Publish_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('app_apps_applications', function($table) {
			$table->increments('id');
            $table->string('app_nicename');
            $table->string('app_folder');
			$table->timestamps();
		});
		Schema::create('app_apps_fbapps', function($table) {
			$table->increments('id');
            $table->string('fbappid');
            $table->string('fbsecret');
            $table->string('fbnamespace')->default('01');
            $table->integer('position')->default(1);
            $table->integer('app_apps_application_id')->default(1);
			$table->timestamps();
		});
		Schema::create('app_user_apps_publishes', function($table) {
			$table->increments('id');
            $table->string('status')->nullable();
            $table->string('app_user_apps_publish_page_id');
            $table->integer('app_apps_fbapp_id')->nullable();
            $table->integer('app_apps_application_id')->default(1);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('app_apps_applications');
		Schema::drop('app_apps_fbapps');
		Schema::drop('app_user_apps_publishes');
	}

}