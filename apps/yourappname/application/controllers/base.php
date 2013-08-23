<?php

class Base_Controller extends Controller {

    public function __construct() {
        $this->data = array();
        View::share('message', Session::get('message'));
    }

    public function __call($method, $parameters) {
        return Response::error('404');
    }

    public static function shareSeoData($seoData) {
    }

}