<?php

class Template extends Eloquent {

    public static $timestamps = true;

    public static $rules = array (
        'name'  => 'required',
    );

    public static function validate($data){
        return  Validator::make($data, static::$rules);
    }
}