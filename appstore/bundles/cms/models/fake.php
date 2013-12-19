<?php

class Fake extends Eloquent 
{
	public static $timestamps = true;

    public static $rules = array (
        'type_id'  => 'required|integer',
        'template_id'  => 'required|integer',
        'page_id'  => 'required|integer',
        'label'  => 'required|max:100',
        'value' => 'required',
        'required' => 'required',
        'info' => 'required',
        'position'  => 'required|integer',
    );

    public static function validate($data){
        return  Validator::make($data, static::$rules);
    }

    public function type() {
        return $this->belongs_to('Type');
    }

    public function page() {
        return $this->belongs_to('Page');
    }

}