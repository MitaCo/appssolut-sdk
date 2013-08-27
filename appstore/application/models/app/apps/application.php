<?php

class App_Apps_Application extends Eloquent {

    public static $timestamps = true;

    
    public function app_apps_fbapps() {
        return $this->has_many('App_Apps_Fbapp');
    }
}