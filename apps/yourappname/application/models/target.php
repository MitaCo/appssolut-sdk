<?php

class Target extends Eloquent {

    public static $timestamps = true;

    public function instance() {
        return $this->belongs_to('Instance');
    }

    public function language() {
        return $this->belongs_to('Language');
    }

    public function country() {
        return $this->belongs_to('Country');
    }

    public function age() {
        return $this->belongs_to('Age');
    }

    public function fields() {
        return $this->has_many('Field');
    }

    public function entries() {
        return $this->has_many('Entry');
    }
}