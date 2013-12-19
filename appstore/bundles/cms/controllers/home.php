<?php

class Cms_Home_Controller extends Cms_Admin_Controller {
    
    public function action_index()
    {
        return View::make('cms::home.index');
    }
}