<?php
class Cms_Admin_Controller extends Base_Controller {

    // public $restful = true;

    public function __construct() {
        parent::__construct();
        /*$this->filter('before', 'auth');
        $this->data = array();
        $user = Auth::user();
        //dd($user);
        // check permission role
        $msg = 'your account seem dont have the right permission to access in this area';
        if (!empty($user) && $user->app_user_role_id < 5){
            //die($msg);
            Auth::logout();
            return Redirect::to_route('get_login')->with('message', $msg);
        }
        
       
       
        // $menu->nest('menuitems', 'cms::menu.partials.menuitem', array('item' => array(1,2,3)));
        // View::share('navmenu', $menu);
        View::share('user', Auth::user());
        View::share('message', Session::get('message'));*/
    }
}