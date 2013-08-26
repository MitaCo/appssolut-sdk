<?php

class Create_Fields_Table {

	public function up()
	{
		Schema::create('fields', function($table) {
			$table->increments('id');
            $table->integer('instance_id');
            $table->integer('type_id');
            $table->integer('template_id');
            $table->integer('page_id');
            $table->integer('target_id');
            $table->string('label', 64);
            $table->text('value')->nullable();
            $table->text('info')->nullable();
            $table->integer('position');
            $table->string('button', 32)->nullable();
            $table->string('property')->nullable();
            $table->boolean('fangate')->default(0);
            $table->boolean('visible')->default(1);
            $table->boolean('editable');
            $table->boolean('required')->default(1);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('fields');
	}

}