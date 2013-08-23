<?php

class Request_Controller extends Base_Controller {

    public $restful = true;

    public function __construct() {
        parent::__construct();
    }

    public function get_invite($hash = null) {
        // has to know where is published
        $app = App::where('app_user_apps_publish_page_id', '=', $hash)->where('app_apps_application_id', '=', APPSOLUTE_APPID)->first();
        $instance = Instance::where_instance($hash)->first();
        $input = Input::all();
        //$tosave = array();
        if (!empty($input['request'])) {
            $request = new Invite(array(
                    'instance_id' => $instance->id,
                    'request_id' => $input['request']
                ));
                if (!$request->save())
                    die($request);
        }
        return Redirect::to($app->fblink);
    }
    public function get_response() {
        return $this->post_response();
    }
    
    public function post_response() {
        $input = Input::all();
        $this->data['url'] = 'http://facebook.com';
        if (!empty($input['request_ids'])) {
            $requests = explode(',', $input['request_ids']);
            foreach($requests as $request) {
                $invite = Invite::where('request_id', '=', $request)->first();
                if (!empty($invite)) {
                    $instance = $invite->instance()->first();
                    $app = App::where('app_user_apps_publish_page_id', '=', $instance->instance)->where('app_apps_application_id', '=', APPSOLUTE_APPID)->first();
                    // return Redirect::to($app->fblink);
                    $this->data['url'] = $app->fblink;
                }
            }
        }
        return View::make('request', $this->data);
        // dd(Input::all());
    }

}