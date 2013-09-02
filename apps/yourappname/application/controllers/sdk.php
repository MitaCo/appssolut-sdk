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
        if (!defined('FB_NAMESPACE') || empty($this->instance_id))
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
        //$app = App:: where('app_user_apps_publish_fbpage_id', '=', $page)->where('app_apps_application_id', '=', APPSOLUTE_APPID)->first();
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
        //  if empty hash from redirect
        if (empty($hash)) {
            $hash = Session::get('hashid', null);
        }
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
            Session::put('age', 13);
            Session::put('liked', true);
            Session::put('isadmin', false);
            return $app->app_user_apps_publish_page_id;
        } 
        Session::flush();
        return;
    }

    // Find most suitable target based on users input
    public function find_target_for($instance, $fbuser) {
        // Get database id's for fbuser age, country, and language
        // dd($fbuser);
        $fbuser_age_id = Age::where_value($fbuser->getAge())->first()->id;
        $fbuser_country_id = Country::where_code(strtoupper($fbuser->getCountry()))->first()->id;
        $fbuser_language_id = Language::where_langcode($fbuser->getlocale())->first()->id;

        // Get all targets based on the user's age
        $targets = Target::where_instance_id($instance->id)->where('age_id', '<=', $fbuser_age_id)->where_active(1)->order_by('age_id', 'desc')->get();
        // Get targets based on country
        $country_targets = array ();
        $all_countries_targets = array ();
        foreach ($targets as $target) {
            if ($fbuser_country_id == $target->country_id) {
                // Keep targets that match the user's country
                $country_targets[] = $target;
            } else if ($target->country_id == 1) {
                // Keep targets that allow any country
                $all_countries_targets[] = $target;
            }
        }
        if (!empty($country_targets)) {
            $targets = $country_targets;
        } else {
            $targets = $all_countries_targets;
        }
        // Get targets based on language
        $language_targets = array ();
        $all_languages_targets = array ();
        foreach ($targets as $target) {
            if ($fbuser_language_id == $target->language_id) {
                // Keep targets that match the user's language
                $language_targets[] = $target;
            } else if ($target->language_id == 1) {
                // Keep targets that allow any language
                $all_languages_targets[] = $target;
            }
        }
        if (!empty($language_targets)) {
            $targets = $language_targets;
        } else {
            $targets = $all_languages_targets;
        }
        // Final target
        if (empty($targets)) {
            $targets[] = Target::where_instance_id($instance->id)->where_age_id(1)->where_country_id(1)->where_language_id(1)->first();
        }
        return $targets[0];
    }

    public function is_eligible($instance, $fbuser) {
        // Get database ID's for fbuser age and country
        $fbuser_age_id = Age::where_value($fbuser->getAge())->first()->id;
        $fbuser_country_id = Country::where_code(strtoupper($fbuser->getCountry()))->first()->id;

        $min_age_id = $instance->setting->age_id;
        if ($fbuser_age_id < $min_age_id) {
            $age_value = Age::find($min_age_id)->value;
            Session::flash('eligibility_message', 'You must have '.$age_value.'+ years to participate.');
            return false;
        }
        $allowed_countries = Allowedcountry::where_instance_id($instance->id)->order_by('country_id')->lists('country_id', 'country_id');
        if (isset($allowed_countries[1]) || isset($allowed_countries[$fbuser_country_id])) {
            return true;
        }
        Session::flash('eligibility_message', 'You are not allowed to participate from this country.');
        return false;
    }

}