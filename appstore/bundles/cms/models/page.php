<?php

class Page extends Eloquent {

    public static $timestamps = true;

    public static $rules = array (
        'name'  => 'required',
        'image'  => 'required',
        'visible'  => 'required|integer',
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

    public function entries() {
        return $this->has_many('Entry');
    }
}