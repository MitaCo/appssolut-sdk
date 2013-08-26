<?php

class Page extends Eloquent {

    public static $timestamps = true;

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