<?php

class Instance extends Eloquent {

    public static $timestamps = true;

    public function setting() {
        return $this->has_one('Setting');
    }

    public function fields() {
        return $this->has_many('Field');
    }

    public function entries() {
        return $this->has_many('Entry');
    }
    
    public function invites() {
        return $this->has_many('invite');
    }

    public function targets() {
        return $this->has_many('Target');
    }

    public function allowedcountries() {
        return $this->has_many('Allowedcountry');
    }
}