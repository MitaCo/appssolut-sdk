<?php

class Type extends Eloquent {

    public static $timestamps = true;

    public static $rules = array (
        'type'  => 'required|max:50|unique:types'
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

    public static function validateAndinsert($value){
        $validation = Validator::make(['type' =>  Str::slug(Str::lower($value))], static::$rules);
        if ($validation->fails()) {
            return array_shift($validation->errors->messages['type']);
        }

        //seed db with new value
        static::create(array(
                            'name' => $value,
                            'type' => Str::slug(Str::lower($value), '-'),
                        )
                    );
    }
}