<?php

class Field extends Eloquent {

    public static $timestamps = true;

    public function instance() {
        return $this->belongs_to('Instance');
    }

    public function type() {
        return $this->belongs_to('Type');
    }

    public function target() {
        return $this->belongs_to('Target');
    }

    public function page() {
        return $this->belongs_to('Page');
    }

    public function storages() {
        return $this->has_many('Storage');
    }
}