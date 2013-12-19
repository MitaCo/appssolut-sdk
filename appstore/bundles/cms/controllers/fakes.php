<?php

/**
 * Author: Muhamed Didovic
 * Date: 12/11/13
 */

class Cms_Fakes_Controller extends Cms_Admin_Controller {
	public $restful = true;

	public function __construct() {
        parent::__construct();
    }
    
    // List all resources
    public function get_index() {
        $data = json_decode(Response::eloquent(Fake::order_by('id')->get()));
        return View::make('cms::fakes.index', compact('data'));
    }

    // Get update form for resource
    public function get_edit($id) {
        $data = json_decode(Response::eloquent(Fake::find($id)));
        return View::make('cms::fakes.edit', compact('data'));
    }

    // Update resource
    public function put_update($id) {
        $postdata = Input::all();
        
        $validation = Fake::validate($postdata);
        if ($validation->fails()) return Redirect::back()->with_errors($validation);
        
        //TO DO fix for upload
        /*if (is_array($postdata['value'])) {
            $file = Input::file('value');
            $extension = File::extension($file['name']);
            $directory = path('public').'uploads/'.sha1(time());
            //$filename = sha1(time().time()).".{$extension}";
            
            if(!Input::upload('file', $directory, $file['name'])) {
                return Redirect::back()->with_errors($validation)->with('message', 'File has not been uploaded, try again!')->with_input();
            } 
        }
        */

        if (!Fake::find($id)->fill($postdata)->save()) {
            return Redirect::back()->with_errors($validation)->with('message', 'Something went wrong try again!')->with_input();
        }

        return Redirect::to_action('cms::fakes')->with('message', 'Resource has been updated');
    }

    // Get new form for resource
    public function get_new() {
        return View::make('cms::fakes.new');
    }

    // insert resource
    public function post_create() {
        $postdata = Input::all();
        
        $validation = Fake::validate($postdata);
        if ($validation->fails()) return Redirect::back()->with_errors($validation);

        Fake::create($postdata);

        return Redirect::to_action('cms::fakes')->with('message', 'Resource has been updated');
    }

    // Delete resource
    public function delete_destroy($id) {
        Fake::find($id)->delete();
        return Redirect::to_action('cms::fakes')->with('message', 'Resource has been deleted');
    }

    
}