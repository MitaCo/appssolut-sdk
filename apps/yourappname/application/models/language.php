<?php

class Language extends Eloquent {

    public static $timestamps = true;

    public function targets() {
        return $this->has_many('Target');
    }
}