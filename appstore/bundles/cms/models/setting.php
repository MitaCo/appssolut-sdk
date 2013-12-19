<?php

class Setting extends Eloquent {

    public static $timestamps = true;

    public static $rules = array (
        'instance_id'  => 'required|integer',
        'template_id'  => 'required|integer',
        'age_id'  => 'required|integer',
        'title'  => 'required|max:100',
        'fangate' => 'required|integer',
        'entry_form' => 'required|integer',
        'background' => 'required',
    );

    public static function validate($data){
        return  Validator::make($data, static::$rules);
    }

    public function instance() {
        return $this->has_one('Instance');
    }
}