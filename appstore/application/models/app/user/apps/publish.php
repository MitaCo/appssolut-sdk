<?php



class App_User_Apps_Publish extends Eloquent {

    public static $timestamps = true;
	
	public function app_apps_fbapp() {
        return $this->belongs_to('App_Apps_Fbapp');
    }

    public function app_apps_application() {
        return $this->belongs_to('App_Apps_Application');
    }
}