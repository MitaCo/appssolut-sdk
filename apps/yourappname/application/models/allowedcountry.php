<?php

class Allowedcountry extends Eloquent {

    public static $timestamps = true;

    public function instance() {
        return $this->belongs_to('Instance');
    }

    public function country() {
        return $this->belongs_to('Country');
    }
}