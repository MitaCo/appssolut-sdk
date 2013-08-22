<?php

class Sdk_Controller extends Base_Controller {

    private $instance_id;
    private $page;
    private $admin = false;

    public function __construct() {
        parent::__construct();
        // dd(Input::all());
        if (defined('FB_NAMESPACE')){
            $fbapp = Fbdata::where('app_apps_application_id', '=', APPSOLUTE_APPID)->where('fbnamespace', '=', FB_NAMESPACE)->first();
            if (!empty($fbapp)) {
                define('APPSSOLUT_FB_ID', $fbapp->id);
                define('APPSSOLUT_FB_APPID', $fbapp->fbappid);
                define('APPSSOLUT_FB_SECRET', $fbapp->fbsecret);
            }
            // dd(Input::all());
            $signed_request = Input::get('signed_request', null);
            if (!empty($signed_request)) {
                // Session::flush();
                // first time acces by facebook

                list($encoded_sig, $payload) = explode('.', $signed_request, 2);

                // decode the data
                $sig = base64_decode(strtr($encoded_sig, '-_', '+/'));
                $data = json_decode(base64_decode(strtr($payload, '-_', '+/')), true);
                // print_r($data);
                $this->page = $data['page']['id'];
                Session::put('fbuid', @$data['user_id']);
                Session::put('fbpage', @$data['page']['id']);
                Session::put('locale', @$data['user']['locale']);
                Session::put('country', @$data['user']['country']);
                Session::put('age', @$data['user']['age']['min']);
                Session::put('liked', @$data['page']['liked']);
                $this->admin = @$data['page']['admin'];
                Session::put('isadmin', @$data['page']['admin']);
                $this->instance_id = $this->get_instanceFromPage($this->page);
                if (!empty($this->instance_id))
                    Session::put('instance_id', $this->instance_id);
            } else {
                // any other time access
                $this->instance_id = Session::get('instance_id', null);
                $this->page = Session::get('fbpage', null);
                $this->admin = Session::get('isadmin', false);
            }
        } else {
            $fbapp = Fbdata::where('app_apps_application_id', '=', APPSOLUTE_APPID)->order_by('position')->first();
            if (!empty($fbapp)) {
                define('APPSSOLUT_FB_ID', $fbapp->id);
                define('APPSSOLUT_FB_APPID', $fbapp->fbappid);
                define('APPSSOLUT_FB_SECRET', $fbapp->fbsecret);
            }
        }
    }

    public function getinstance($hash = null) {
        if (!defined('FB_NAMESPACE') OR empty($this->instance_id))
            $this->instance_id = $this->get_instanceHash($hash);
        return $this->instance_id;
    }
    public function getFbPage() {
        return $this->page;
    }
    public function isAdmin() {
        return $this->admin;
    }

    private function get_instanceFromPage($page) {
        // from facebook
        // $app = App:: where('app_user_apps_publish_fbpage_id', '=', $page)->where('app_apps_application_id', '=', APPSOLUTE_APPID)->first();
        $app = App:: where('app_user_apps_publish_fbpage_id', '=', $page)->where('app_apps_fbapp_id', '=', APPSSOLUT_FB_ID)->first();
        // dd($app);
        if (!$this->admin and (empty($app->status) or $app->status != 'A'))
            return;
        // print_r($app);
        
        if (!empty($app->app_user_apps_publish_page_id)) {
            Session::put('return_url', $app->fblink);
            Session::put('hashid', $app->app_user_apps_publish_page_id);
            return $app->app_user_apps_publish_page_id;
        } 
        Session::flush();
        return;
        
        
    }
    private function get_instanceHash($hash) {
        // get from address suppose to be only out of facebook or for preview porpuse
        $app = App::where('app_user_apps_publish_page_id', '=', $hash)->where('app_apps_application_id', '=', APPSOLUTE_APPID)->first();
        // dd($app);
        if (empty($app->status) or $app->status != 'A')
            return;
        if (!empty($app->app_user_apps_publish_page_id)) {
            // Session::flush();
            Session::put('hashid', $hash);
            Session::put('return_url', URL::base().'/'.$hash);
            Session::put('fbuid', 0);
            Session::put('fbpage', '');
            Session::put('locale', 'en_US');
            Session::put('country', 'us');
            Session::put('age', 21);
            Session::put('liked', true);
            Session::put('isadmin', false);
            return $app->app_user_apps_publish_page_id;
        } 
        Session::flush();
        return;
        
    }

}