<?php

class Create_Fakes_Table {

	public function up()
	{
		Schema::create('fakes', function($table) {
            $table->increments('id');
            $table->integer('type_id');
            $table->integer('template_id');
            $table->integer('page_id');
            $table->string('label', 64);
            $table->text('value')->nullable();
            $table->text('info')->nullable();
            $table->integer('position');
            $table->boolean('required')->default(1);
            $table->string('button', 32)->nullable();
            $table->string('property')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('fakes');
	}

}