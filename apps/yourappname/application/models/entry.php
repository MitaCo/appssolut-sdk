<?php

class Entry extends Eloquent {

    public static $timestamps = true;

    public function storages() {
        return $this->has_many('Storage');
    }

    public function instance() {
        return $this->belongs_to('Instance');
    }

    public function page() {
        return $this->belongs_to('Page');
    }
}