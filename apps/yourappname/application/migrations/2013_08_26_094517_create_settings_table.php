<?php

class Create_Settings_Table {

	public function up()
	{
		Schema::create('settings', function($table) {
            $table->increments('id');
            $table->integer('instance_id');
            $table->integer('template_id');
            $table->integer('age_id');
            $table->string('title');
            $table->boolean('fangate')->default(1);
            $table->boolean('entry_form')->default(1);
            $table->text('css')->nullable();
            $table->string('background')->nullable();
            $table->text('privacy')->nullable();
            $table->text('terms')->nullable();
            $table->text('roles')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}

}