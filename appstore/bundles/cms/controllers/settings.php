<?php

class Cms_Settings_Controller extends Cms_Admin_Controller 
{
	public $restful = true;

	public function __construct() {
        parent::__construct();
    }
    
    // List all resources
    public function get_index() {
        $data = json_decode(Response::eloquent(Setting::order_by('id')->get()));
        return View::make('cms::settings.index', compact('data'));
    }

    // Get update form for resource
    public function get_edit($id) {
        $data = json_decode(Response::eloquent(Setting::find($id)));
        return View::make('cms::settings.edit', compact('data'));
    }

    // Update resource
    public function put_update($id) {
        $postdata = Input::all();
        
        $validation = Setting::validate($postdata);
        if ($validation->fails()) return Redirect::back()->with_errors($validation);
        
        
        if (!Setting::find($id)->fill($postdata)->save()) {
            return Redirect::back()->with_errors($validation)->with('message', 'Something went wrong try again!')->with_input();
        }

        return Redirect::to_action('cms::settings')->with('message', 'Resource has been updated');
    }

    // Get new form for resource
    public function get_new() {
        return View::make('cms::settings.new');
    }

    // insert resource
    public function post_create() {
        $postdata = Input::all();
        
        $validation = Setting::validate($postdata);
        if ($validation->fails()) return Redirect::back()->with_errors($validation);

        Setting::create($postdata);

        return Redirect::to_action('cms::settings')->with('message', 'Resource has been updated');
    }

    // Delete resource
    public function delete_destroy($id) {
        Setting::find($id)->delete();
        return Redirect::to_action('cms::settings')->with('message', 'Resource has been deleted');
    }
}