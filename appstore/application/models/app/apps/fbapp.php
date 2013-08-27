<?php

class App_Apps_Fbapp extends Eloquent {

    public static $timestamps = true;

    public function app_apps_application() {
        return $this->belongs_to('App_Apps_Application');
    }

    public function app_user_apps_publishes() {
        return $this->has_many('App_User_Apps_Publish');
    }
}