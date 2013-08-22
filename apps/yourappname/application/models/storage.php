<?php

class Storage extends Eloquent {

    public static $timestamps = true;

    public function entry() {
        return $this->belongs_to('Entry');
    }

    public function field() {
        return $this->belongs_to('Field');
    }
}