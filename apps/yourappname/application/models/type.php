<?php

class Type extends Eloquent {

    public static $timestamps = true;

    public static $rules = array (
        'type'  => 'required|max:50'
    );

    public static function validate($data){
        return  Validator::make($data, static::$rules);
    }

    public function fields() {
        return $this->has_many('Field');
    }

    public function fakes() {
        return $this->has_many('Fake');
    }
}