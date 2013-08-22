<?php

class Invite extends Eloquent {

    public static $timestamps = true;
    
    public function instance() {
        return $this->belongs_to('Instance');
    }
}