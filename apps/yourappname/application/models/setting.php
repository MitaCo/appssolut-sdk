<?php

class Setting extends Eloquent {

    public static $timestamps = true;

    public function instance() {
        return $this->has_one('Instance');
    }
}